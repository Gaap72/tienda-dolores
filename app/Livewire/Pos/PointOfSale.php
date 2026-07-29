<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

/**
 * Componente Livewire del Punto de Venta (POS).
 * Permite buscar productos, gestionar un carrito de compras temporal,
 * calcular montos de cobro/cambio y procesar la transacción disminuyendo el stock.
 */
class PointOfSale extends Component
{
    // Búsqueda en tiempo real (por nombre o código de barras)
    public $search = '';

    // Arreglo que contiene los elementos agregados al carrito actual
    public $cart = [];

    // Propiedades del módulo de pago
    public $total = 0;      // Total de la venta acumulado
    public $received = '';  // Dinero recibido del cliente
    public $change = 0;     // Cambio a entregar al cliente

    /**
     * Carga el estado inicial del carrito guardado en sesión.
     */
    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    /**
     * Monitorea la propiedad search. Si detecta una coincidencia exacta de código de barras,
     * agrega automáticamente el producto al carrito y limpia la barra de búsqueda.
     */
    public function updatedSearch()
    {
        if (empty($this->search)) {
            return;
        }

        // Búsqueda exacta de código de barras
        $product = Product::where('barcode', $this->search)
            ->where('is_active', true)
            ->first();

        if ($product) {
            $this->addToCart($product->id);
            $this->search = '';
        }
    }

    /**
     * Calcula automáticamente el cambio cuando se actualiza el dinero recibido.
     */
    public function updatedReceived()
    {
        $receivedVal = floatval($this->received);
        if ($receivedVal >= $this->total) {
            $this->change = $receivedVal - $this->total;
        } else {
            $this->change = 0;
        }
    }

    /**
     * Agrega un producto al carrito de compras validando stock disponible.
     */
    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        if ($product->stock <= 0) {
            session()->flash('error', "El producto '{$product->name}' no tiene stock disponible.");
            return;
        }

        $cart = session()->get('cart', []);

        // Si ya está en el carrito, incrementa la cantidad validando el stock
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] + 1 > $product->stock) {
                session()->flash('error', "No hay suficiente stock de '{$product->name}'.");
                return;
            }
            $cart[$productId]['quantity']++;
            $cart[$productId]['subtotal'] = $cart[$productId]['quantity'] * $cart[$productId]['price'];
        } else {
            // Si es un producto nuevo en el carrito, lo inserta con cantidad 1
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => floatval($product->price),
                'quantity' => 1,
                'subtotal' => floatval($product->price),
            ];
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->calculateTotals();
    }

    /**
     * Actualiza la cantidad de un artículo directamente desde el input de cantidad.
     */
    public function updateQuantity($productId, $qty)
    {
        $qty = intval($qty);
        $product = Product::find($productId);

        if (!$product || $qty <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        if ($qty > $product->stock) {
            session()->flash('error', "Solo hay {$product->stock} unidades disponibles de '{$product->name}'.");
            $qty = $product->stock;
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $qty;
            $cart[$productId]['subtotal'] = $qty * $cart[$productId]['price'];
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->calculateTotals();
    }

    /**
     * Elimina un artículo del carrito.
     */
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->calculateTotals();
    }

    /**
     * Recalcula el monto total de la compra y actualiza el cambio.
     */
    public function calculateTotals()
    {
        $this->total = collect($this->cart)->sum('subtotal');
        $this->updatedReceived();
    }

    /**
     * Procesa la venta finalizando la transacción: actualiza stocks y genera movimientos de inventario.
     */
    public function processSale()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'El carrito está vacío.');
            return;
        }

        $receivedVal = floatval($this->received);
        if ($receivedVal < $this->total) {
            session()->flash('error', 'El dinero recibido es menor que el total de la venta.');
            return;
        }

        try {
            DB::transaction(function () {
                foreach ($this->cart as $item) {
                    // Bloquea el producto para prevenir condiciones de carrera
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para '{$product->name}'.");
                    }

                    // Reduce el stock físico
                    $product->stock -= $item['quantity'];
                    $product->save();

                    // Crea el registro del movimiento de inventario de tipo 'salida'
                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'type' => 'salida',
                        'quantity' => $item['quantity'],
                        'reason' => 'Venta POS',
                        'user_id' => auth()->id() ?? User::first()?->id ?? null,
                    ]);
                }
            });

            // Resetea el carrito y estados tras la venta exitosa
            $changeMade = $this->change;
            session()->forget('cart');
            $this->cart = [];
            $this->reset(['received', 'change', 'total', 'search']);
            
            session()->flash('message', 'Venta procesada con éxito. Cambio a entregar: $' . number_format($changeMade, 2));

        } catch (\Exception $e) {
            session()->flash('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Procesa una venta registrada en modo offline y sincronizada al reconectar.
     */
    public function processOfflineSale($cartItems, $received)
    {
        $this->cart = $cartItems;
        $this->received = $received;
        $this->calculateTotals();
        $this->processSale();
    }

    /**
     * Carga y filtra los productos de catálogo rápido y auto-completados de búsqueda.
     */
    public function render()
    {
        $searchResults = [];
        if (!empty($this->search)) {
            $searchResults = Product::where('is_active', true)
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('barcode', 'like', '%' . $this->search . '%');
                })
                ->take(5)
                ->get();
        }

        $quickProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('livewire.pos.point-of-sale', [
            'searchResults' => $searchResults,
            'quickProducts' => $quickProducts,
        ])->layout('components.layouts.app');
    }
}
