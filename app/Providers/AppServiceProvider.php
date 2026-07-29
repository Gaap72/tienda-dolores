<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fuerza el esquema HTTPS en producción para evitar problemas de mixed content con proxies (como Railway / Cloudflare)
        if (config('app.env') === 'production' || app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Solución de Resiliencia en Producción: Si la base de datos sqlite está vacía o no tiene usuarios, migra y siembra automáticamente
        try {
            if (!Schema::hasTable('users') || User::count() === 0) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Exception $e) {
            // Failsafe silencioso para evitar bloquear la carga inicial
        }
    }
}
