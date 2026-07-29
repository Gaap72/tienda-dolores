<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $products = [
            // Abarrotes
            [
                'category_id' => $categories['abarrotes']->id,
                'barcode' => '7501000111221',
                'name' => 'Arroz Súper Extra 1kg',
                'description' => 'Arroz grano largo de alta calidad.',
                'price' => 32.50,
                'cost' => 22.00,
                'stock' => 50,
                'stock_min' => 10,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['arroz', 'despensa', 'básicos'],
                'image_path' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400',
            ],
            [
                'category_id' => $categories['abarrotes']->id,
                'barcode' => '7501000111222',
                'name' => 'Frijol Negro Querétaro 1kg',
                'description' => 'Frijol negro seleccionado de alta calidad.',
                'price' => 38.00,
                'cost' => 26.50,
                'stock' => 40,
                'stock_min' => 10,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['frijol', 'despensa', 'legumbres'],
                'image_path' => 'https://images.unsplash.com/photo-1551462147-ff29053bfc14?w=400',
            ],
            [
                'category_id' => $categories['abarrotes']->id,
                'barcode' => '7501000111223',
                'name' => 'Aceite Vegetal Canola 1Lt',
                'description' => 'Aceite vegetal comestible para cocinar.',
                'price' => 45.00,
                'cost' => 32.00,
                'stock' => 30,
                'stock_min' => 8,
                'unit_measure' => 'lt',
                'is_active' => true,
                'tags' => ['aceite', 'cocina'],
                'image_path' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400',
            ],

            // Bebidas
            [
                'category_id' => $categories['bebidas']->id,
                'barcode' => '7501055300016',
                'name' => 'Coca Cola Original 600ml',
                'description' => 'Refresco de cola sabor original.',
                'price' => 18.50,
                'cost' => 13.00,
                'stock' => 120,
                'stock_min' => 24,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['refresco', 'cola', 'frío'],
                'image_path' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=400',
            ],
            [
                'category_id' => $categories['bebidas']->id,
                'barcode' => '7501055300023',
                'name' => 'Agua Purificada Ciel 1.5Lt',
                'description' => 'Agua purificada embotellada.',
                'price' => 15.00,
                'cost' => 8.50,
                'stock' => 60,
                'stock_min' => 12,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['agua', 'hidratación'],
                'image_path' => 'https://images.unsplash.com/photo-1608885898957-a599fb18de33?w=400',
            ],
            [
                'category_id' => $categories['bebidas']->id,
                'barcode' => '7501055300030',
                'name' => 'Jugo de Naranja Del Valle 1Lt',
                'description' => 'Jugo de naranja natural en envase Tetra Pak.',
                'price' => 26.00,
                'cost' => 18.00,
                'stock' => 35,
                'stock_min' => 6,
                'unit_measure' => 'lt',
                'is_active' => true,
                'tags' => ['jugo', 'desayuno'],
                'image_path' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=400',
            ],

            // Botanas
            [
                'category_id' => $categories['botanas']->id,
                'barcode' => '7501011123456',
                'name' => 'Papas Sabritas Sal 110g',
                'description' => 'Papas fritas con sal.',
                'price' => 42.00,
                'cost' => 30.00,
                'stock' => 45,
                'stock_min' => 10,
                'unit_measure' => 'cja',
                'is_active' => true,
                'tags' => ['papas', 'botana', 'salado'],
                'image_path' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=400',
            ],
            [
                'category_id' => $categories['botanas']->id,
                'barcode' => '7501011123463',
                'name' => 'Doritos Nacho 146g',
                'description' => 'Totopos de maíz sabor queso nacho.',
                'price' => 44.00,
                'cost' => 31.50,
                'stock' => 50,
                'stock_min' => 10,
                'unit_measure' => 'cja',
                'is_active' => true,
                'tags' => ['doritos', 'queso', 'botana'],
                'image_path' => 'https://images.unsplash.com/photo-1599490659213-e2b9527b0876?w=400',
            ],
            [
                'category_id' => $categories['botanas']->id,
                'barcode' => '7501011123470',
                'name' => 'Cacahuates Japoneses Barcel 150g',
                'description' => 'Cacahuates con envoltura crujiente.',
                'price' => 22.00,
                'cost' => 15.00,
                'stock' => 30,
                'stock_min' => 5,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['cacahuates', 'botana'],
                'image_path' => 'https://images.unsplash.com/photo-1534127393081-18086326e8a8?w=400',
            ],

            // Lácteos
            [
                'category_id' => $categories['lacteos']->id,
                'barcode' => '7501020512345',
                'name' => 'Leche Entera Lala 1Lt',
                'description' => 'Leche entera pasteurizada de vaca.',
                'price' => 27.50,
                'cost' => 20.00,
                'stock' => 80,
                'stock_min' => 15,
                'unit_measure' => 'lt',
                'is_active' => true,
                'tags' => ['leche', 'lácteos', 'desayuno'],
                'image_path' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=400',
            ],
            [
                'category_id' => $categories['lacteos']->id,
                'barcode' => '7501020512352',
                'name' => 'Queso Oaxaca La Villita 400g',
                'description' => 'Queso tipo Oaxaca para deshebrar.',
                'price' => 85.00,
                'cost' => 62.00,
                'stock' => 20,
                'stock_min' => 5,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['queso', 'oaxaca'],
                'image_path' => 'https://images.unsplash.com/photo-1528256423883-b1d519358b97?w=400',
            ],
            [
                'category_id' => $categories['lacteos']->id,
                'barcode' => '7501020512369',
                'name' => 'Yogurt Griego Fresa Oikos 150g',
                'description' => 'Yogurt griego sabor fresa cremoso.',
                'price' => 19.00,
                'cost' => 13.50,
                'stock' => 40,
                'stock_min' => 8,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['yogurt', 'griego', 'fresa'],
                'image_path' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400',
            ],

            // Limpieza
            [
                'category_id' => $categories['limpieza']->id,
                'barcode' => '7501030212345',
                'name' => 'Jabón Líquido Trastes Salvo 750ml',
                'description' => 'Jabón líquido lavatrastes arranca grasa.',
                'price' => 39.50,
                'cost' => 28.00,
                'stock' => 25,
                'stock_min' => 5,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['jabón', 'limpieza', 'trastes'],
                'image_path' => 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=400',
            ],
            [
                'category_id' => $categories['limpieza']->id,
                'barcode' => '7501030212352',
                'name' => 'Limpiador Multiusos Fabuloso Fresca Lavanda 1Lt',
                'description' => 'Limpiador líquido aromático para pisos.',
                'price' => 28.00,
                'cost' => 19.50,
                'stock' => 30,
                'stock_min' => 6,
                'unit_measure' => 'lt',
                'is_active' => true,
                'tags' => ['limpiador', 'pisos', 'lavanda'],
                'image_path' => 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?w=400',
            ],
            [
                'category_id' => $categories['limpieza']->id,
                'barcode' => '7501030212369',
                'name' => 'Detergente en Polvo Ariel 1kg',
                'description' => 'Detergente en polvo para ropa blanca y de color.',
                'price' => 48.00,
                'cost' => 34.00,
                'stock' => 35,
                'stock_min' => 8,
                'unit_measure' => 'pza',
                'is_active' => true,
                'tags' => ['detergente', 'ropa', 'ariel'],
                'image_path' => 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=400',
            ],
        ];

        foreach ($products as $productData) {
            Product::updateOrCreate([
                'barcode' => $productData['barcode'],
            ], $productData);
        }
    }
}
