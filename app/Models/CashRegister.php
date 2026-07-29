<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

/**
 * Modelo Eloquent para la tabla 'cash_registers' (Cortes de caja y arqueos).
 */
#[Fillable([
    'user_id',
    'opened_at',
    'closed_at',
    'opening_amount',
    'sales_amount',
    'expected_amount',
    'actual_amount',
    'difference',
    'status',
])]
class CashRegister extends Model
{
    use HasFactory;

    /**
     * Castings automáticos.
     */
    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'opening_amount' => 'decimal:2',
            'sales_amount' => 'decimal:2',
            'expected_amount' => 'decimal:2',
            'actual_amount' => 'decimal:2',
            'difference' => 'decimal:2',
        ];
    }

    /**
     * Relación: Pertenece a un Usuario/Cajero.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
