<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tenancy\TenantContext;
use App\Tenancy\TenantContextManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(TenantContext::class);
        $this->app->scoped(TenantContextManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
