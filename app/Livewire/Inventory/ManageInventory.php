<?php

namespace App\Livewire\Inventory;

use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

/**
 * Componente Livewire para controlar el inventario y movimientos.
 * Permite realizar registros manuales de entradas, salidas y ajustes,
 * así como visualizar el historial completo de movimientos en una bitácora paginada.
 */
class ManageInventory extends Component
{
    use WithPagination;

    // Propiedad para filtrar la bitácora de movimientos en tiempo real
    public $search = '';

    // Propiedades vinculadas al formulario de registro de movimientos
    public $product_id = ''; // ID del producto seleccionado
    public $type = 'entrada'; // Tipo de movimiento ('entrada', 'salida', 'ajuste')
    public $quantity = '';    // Cantidad a ingresar, retirar o valor absoluto del nuevo stock
    public $reason = '';      // Justificación o motivo del movimiento

    /**
     * Resetea la página actual cuando se cambia el filtro de búsqueda.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reglas de validación para registrar un movimiento de inventario.
     */
    protected function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entrada,salida,ajuste',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ];
    }

    /**
     * Guarda el movimiento de inventario, actualiza el stock correspondiente
     * del producto en base de datos bajo una transacción SQL.
     */
    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Bloquea el registro del producto para asegurar consistencia
                $product = Product::lockForUpdate()->findOrFail($this->product_id);
                $oldStock = $product->stock;
                $qty = intval($this->quantity);

                // Determina la lógica de actualización de stock y el valor de auditoría
                if ($this->type === 'entrada') {
                    $product->stock += $qty;
                    $movementQty = $qty;
                } elseif ($this->type === 'salida') {
                    if ($product->stock < $qty) {
                        throw new \Exception("Stock insuficiente. El stock actual de '{$product->name}' es {$product->stock}.");
                    }
                    $product->stock -= $qty;
                    $movementQty = $qty;
                } else { // ajuste (reemplazo físico directo)
                    $product->stock = $qty;
                    // Almacena la diferencia relativa calculada para el registro contable
                    $movementQty = $qty - $oldStock; 
                }

                // Guarda el nuevo stock
                $product->save();

                // Registra la fila en la bitácora de movimientos
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'type' => $this->type,
                    'quantity' => $movementQty,
                    'reason' => $this->reason,
                    'user_id' => auth()->id() ?? User::first()?->id ?? null,
                ]);
            });

            // Resetea el formulario tras guardar
            $this->reset(['product_id', 'quantity', 'reason']);
            $this->type = 'entrada';

            session()->flash('message', 'Movimiento de inventario registrado correctamente.');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Renderiza la vista cargando todos los productos activos y el historial de movimientos paginado.
     */
    public function render()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();

        $movements = InventoryMovement::with(['product', 'user'])
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reason', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('livewire.inventory.manage-inventory', [
            'products' => $products,
            'movements' => $movements,
        ])->layout('components.layouts.app');
    }
}
