<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea o actualiza Administrador
        User::updateOrCreate(
            ['email' => 'admin@tiendadolores.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        // Crea o actualiza Cajero
        User::updateOrCreate(
            ['email' => 'cajero@tiendadolores.com'],
            [
                'name' => 'Cajero Principal',
                'password' => bcrypt('password123'),
                'role' => 'cajero',
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
