<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ManageProducts;
use App\Livewire\Pos\PointOfSale;
use App\Livewire\Inventory\ManageInventory;
use App\Livewire\Users\ManageUsers;
use App\Livewire\Dashboard\Overview;
use App\Livewire\Categories\ManageCategories;
use App\Livewire\Inventory\ManageWastes;
use App\Livewire\Cash\CashRegister;
use App\Livewire\Auth\Login;

// Ruta de Login para visitantes
Route::get('/login', Login::class)->name('login');

// Cierre de sesión (Logout)
Route::post('/logout', [Login::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Grupo de rutas exclusivas para el Administrador
    Route::middleware(['role:admin'])->group(function () {
        // Ruta raíz: Panel de control (Dashboard)
        Route::get('/', Overview::class)->name('dashboard');

        // Ruta para la administración y catálogo de productos
        Route::get('/productos', ManageProducts::class)->name('products.manage');

        // Ruta para la gestión de categorías
        Route::get('/categorias', ManageCategories::class)->name('categories.manage');

        // Ruta para el control de inventario y bitácora de movimientos
        Route::get('/inventario', ManageInventory::class)->name('inventory.manage');

        // Ruta para la gestión de mermas y caducidades
        Route::get('/mermas', ManageWastes::class)->name('wastes.manage');

        // Ruta para la administración de usuarios y cajeros
        Route::get('/usuarios', ManageUsers::class)->name('users.manage');
    });

    // Grupo de rutas accesibles tanto por Administrador como por Cajero
    Route::middleware(['role:admin,cajero'])->group(function () {
        // Ruta para el Punto de Venta (POS) - Realizar ventas y cobros
        Route::get('/pos', PointOfSale::class)->name('pos');

        // Ruta para el corte de caja y arqueo de efectivo
        Route::get('/corte-caja', CashRegister::class)->name('cash.register');
    });

});
