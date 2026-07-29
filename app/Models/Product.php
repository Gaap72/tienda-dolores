<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

/**
 * Modelo Eloquent para la tabla 'products' (Productos del catálogo).
 */
#[Fillable([
    'category_id',
    'barcode',
    'name',
    'description',
    'price',
    'cost',
    'stock',
    'stock_min',
    'unit_measure',
    'is_active',
    'tags',
    'image_path',
])]
class Product extends Model
{
    use HasFactory;

    /**
     * Define los castings automáticos para los atributos de la base de datos.
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost' => 'decimal:2',
            'stock' => 'integer',
            'stock_min' => 'integer',
            'is_active' => 'boolean',
            'tags' => 'array', // Convierte el campo JSON de la base de datos a un arreglo PHP
        ];
    }

    /**
     * Relación muchos a uno: Un producto pertenece a una categoría.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación uno a muchos: Un producto puede tener muchas variantes.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relación uno a muchos: Un producto registra muchos movimientos de inventario.
     */
    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
