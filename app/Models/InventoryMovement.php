<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

/**
 * Modelo Eloquent para la tabla 'inventory_movements' (Bitácora de entradas, salidas y ajustes de stock).
 */
#[Fillable([
    'product_id',
    'type',
    'quantity',
    'reason',
    'user_id',
])]
class InventoryMovement extends Model
{
    use HasFactory;

    /**
     * Define los castings automáticos para los atributos de la base de datos.
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    /**
     * Relación muchos a uno: Un movimiento pertenece a un producto en específico.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación muchos a uno: Un movimiento es realizado por un usuario (cajero/admin).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
