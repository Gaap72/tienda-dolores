<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Abarrotes',
            'Bebidas',
            'Botanas',
            'Lácteos',
            'Limpieza',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate([
                'slug' => Str::slug($categoryName),
            ], [
                'name' => $categoryName,
                'description' => "Categoría de {$categoryName}",
                'is_active' => true,
            ]);
        }
    }
}
