<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra qualquer serviço de aplicação.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap qualquer serviço de aplicação.
     * Carrega as rotas da API e web.
     */
    public function boot(): void
    {
        // Carrega as rotas da API com prefixo /api e middleware 'api'
        \Illuminate\Support\Facades\Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Carrega as rotas web
        \Illuminate\Support\Facades\Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
