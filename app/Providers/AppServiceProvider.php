<?php

namespace App\Providers;

use App\Models\Pagamento;
use App\Policies\PagamentoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Gate::policy(Pagamento::class, PagamentoPolicy::class);
        
           Schema::defaultStringLength(191);
    }
}
