<?php

namespace App\Livewire\Dashboard;

use App\Models\Product;
use App\Models\InventoryMovement;
use Livewire\Component;

/**
 * Componente Livewire del Panel de Control (Dashboard)
 * Proporciona estadísticas clave en tiempo real sobre las operaciones de la tienda.
 */
class Overview extends Component
{
    /**
     * Renderiza la vista del dashboard con los KPIs calculados.
     */
    public function render()
    {
        // 1. Calcula las ventas acumuladas del día de hoy sumando cantidad * precio del producto
        $todaySales = InventoryMovement::whereDate('inventory_movements.created_at', today())
            ->where('inventory_movements.type', 'salida')
            ->where('inventory_movements.reason', 'like', '%Venta POS%')
            ->join('products', 'inventory_movements.product_id', '=', 'products.id')
            ->selectRaw('SUM(inventory_movements.quantity * products.price) as total')
            ->value('total') ?? 0;

        // 2. Cuenta los productos cuyo inventario está por debajo o igual al stock mínimo configurado
        $lowStockCount = Product::where('is_active', true)
            ->whereColumn('stock', '<=', 'stock_min')
            ->count();

        // 3. Cuenta el total general de productos activos registrados en el catálogo
        $totalProducts = Product::where('is_active', true)->count();

        // 4. Obtiene los últimos 5 movimientos de inventario registrados (entradas, salidas o ajustes)
        $recentMovements = InventoryMovement::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Retorna la vista del dashboard inyectándole los datos estadísticos
        return view('livewire.dashboard.overview', [
            'todaySales' => floatval($todaySales),
            'lowStockCount' => $lowStockCount,
            'totalProducts' => $totalProducts,
            'recentMovements' => $recentMovements,
        ])->layout('components.layouts.app');
    }
}
