<?php

namespace App\Livewire\Inventory;

use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ManageWastes extends Component
{
    use WithPagination;

    // Form fields
    public $product_id = '';
    public $quantity = '';
    public $type = 'caducado'; // caducado, dañado, roto, robo
    public $notes = '';

    // Search query for table history
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:caducado,dañado,roto,robo',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $product = Product::lockForUpdate()->findOrFail($this->product_id);
                $qty = intval($this->quantity);

                if ($product->stock < $qty) {
                    throw new \Exception("Stock insuficiente para reportar merma. El stock actual de '{$product->name}' es {$product->stock}.");
                }

                // Descuenta del stock del producto
                $product->stock -= $qty;
                $product->save();

                // Formatea la razón del movimiento
                $formattedReason = "Merma: " . ucfirst($this->type) . ($this->notes ? " | " . $this->notes : "");

                // Registra el movimiento en inventory_movements como salida
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'type' => 'salida',
                    'quantity' => $qty,
                    'reason' => $formattedReason,
                    'user_id' => auth()->id() ?? User::first()?->id ?? null,
                ]);
            });

            $this->reset(['product_id', 'quantity', 'notes']);
            $this->type = 'caducado';

            session()->flash('message', 'Merma registrada correctamente.');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        // Obtiene productos activos
        $products = Product::where('is_active', true)->orderBy('name')->get();

        // Obtiene historial de mermas
        $wastes = InventoryMovement::with(['product', 'user'])
            ->where('reason', 'like', 'Merma:%')
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reason', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        // Calcula pérdidas estimadas de las mermas consultadas
        $totalLoss = InventoryMovement::where('reason', 'like', 'Merma:%')
            ->join('products', 'inventory_movements.product_id', '=', 'products.id')
            ->selectRaw('SUM(inventory_movements.quantity * products.cost) as loss')
            ->value('loss') ?? 0;

        return view('livewire.inventory.manage-wastes', [
            'products' => $products,
            'wastes' => $wastes,
            'totalLoss' => floatval($totalLoss),
        ])->layout('components.layouts.app');
    }
}
