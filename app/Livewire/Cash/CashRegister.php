<?php

namespace App\Livewire\Cash;

use App\Models\CashRegister as CashShift;
use App\Models\InventoryMovement;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CashRegister extends Component
{
    use WithPagination;

    // Shift status
    public $activeShift = null;

    // Opening form fields
    public $opening_amount = '';

    // Closing form fields
    public $actual_amount = '';

    // Calculation properties (read-only)
    public $sales_amount = 0;
    public $expected_amount = 0;

    protected function rules()
    {
        if ($this->activeShift) {
            return [
                'actual_amount' => 'required|numeric|min:0',
            ];
        } else {
            return [
                'opening_amount' => 'required|numeric|min:0',
            ];
        }
    }

    public function mount()
    {
        $this->loadActiveShift();
    }

    public function loadActiveShift()
    {
        // Finds open shift for the current user (or general open shift)
        $this->activeShift = CashShift::where('status', 'open')
            ->latest()
            ->first();

        if ($this->activeShift) {
            $this->calculateShiftSales();
        }
    }

    public function calculateShiftSales()
    {
        if (!$this->activeShift) {
            return;
        }

        // Calculates sum of sales made after opened_at
        $sales = InventoryMovement::where('inventory_movements.created_at', '>=', $this->activeShift->opened_at)
            ->where('inventory_movements.type', 'salida')
            ->where('inventory_movements.reason', 'like', '%Venta POS%')
            ->join('products', 'inventory_movements.product_id', '=', 'products.id')
            ->selectRaw('SUM(inventory_movements.quantity * products.price) as total')
            ->value('total') ?? 0;

        $this->sales_amount = floatval($sales);
        $this->expected_amount = floatval($this->activeShift->opening_amount) + $this->sales_amount;
    }

    public function openShift()
    {
        $this->validate();

        $userId = auth()->id() ?? User::first()?->id ?? null;
        if (!$userId) {
            session()->flash('error', 'Debes registrar al menos un usuario/cajero para abrir caja.');
            return;
        }

        CashShift::create([
            'user_id' => $userId,
            'opened_at' => now(),
            'opening_amount' => floatval($this->opening_amount),
            'status' => 'open',
        ]);

        $this->reset(['opening_amount']);
        $this->loadActiveShift();
        session()->flash('message', 'Caja abierta con éxito. Fondo de caja registrado.');
    }

    public function closeShift()
    {
        $this->validate();
        $this->calculateShiftSales();

        $actual = floatval($this->actual_amount);
        $diff = $actual - $this->expected_amount;

        $this->activeShift->update([
            'closed_at' => now(),
            'sales_amount' => $this->sales_amount,
            'expected_amount' => $this->expected_amount,
            'actual_amount' => $actual,
            'difference' => $diff,
            'status' => 'closed',
        ]);

        $this->reset(['actual_amount']);
        $this->activeShift = null;
        session()->flash('message', 'Caja cerrada y arqueo completado. Diferencia calculada: $' . number_format($diff, 2));
    }

    public function render()
    {
        // History of closed shifts
        $shiftsHistory = CashShift::with('user')
            ->where('status', 'closed')
            ->latest()
            ->paginate(10);

        return view('livewire.cash.cash-register', [
            'shiftsHistory' => $shiftsHistory,
        ])->layout('components.layouts.app');
    }
}
