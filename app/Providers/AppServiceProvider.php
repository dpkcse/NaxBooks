<?php

namespace App\Providers;

use App\Contracts\Tenancy\CurrentTenant;
use App\Support\Tenancy\CurrentTenantContext;
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
        // Parallel shared-schema foundation. Existing runtime context remains active.
        $this->app->scoped(CurrentTenant::class, CurrentTenantContext::class);
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
