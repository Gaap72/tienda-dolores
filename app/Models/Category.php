<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

/**
 * Modelo Eloquent para la tabla 'categories' (Categorías de productos).
 */
#[Fillable(['name', 'slug', 'description', 'is_active'])]
class Category extends Model
{
    use HasFactory;

    /**
     * Define los castings automáticos para los atributos de la base de datos.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean', // Convierte el valor de base de datos a booleano verdadero/falso
        ];
    }

    /**
     * Relación uno a muchos: Una categoría contiene muchos productos.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
