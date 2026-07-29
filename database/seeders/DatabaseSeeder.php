<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'pin_code' => '1234',
            ]
        );

        // Crea o actualiza Cajero
        User::updateOrCreate(
            ['email' => 'cajero@tiendadolores.com'],
            [
                'name' => 'Cajero Principal',
                'password' => Hash::make('password123'),
                'role' => 'cajero',
                'pin_code' => '4321',
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
