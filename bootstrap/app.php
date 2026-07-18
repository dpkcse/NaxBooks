<?php

use App\Http\Middleware\AssignRequestId;
use App\Http\Middleware\EnsurePlatformAdmin;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\{ResolveTenantFromDomain, EnsureTenantIsOperational, EnsureActiveTenantMembership, InitializeTenantDatabase, ClearTenantContext};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [AssignRequestId::class, EnsureUserIsActive::class]);
        $middleware->alias(['platform.admin' => EnsurePlatformAdmin::class, 'tenant.resolve' => ResolveTenantFromDomain::class, 'tenant.operational' => EnsureTenantIsOperational::class, 'tenant.membership' => EnsureActiveTenantMembership::class, 'tenant.initialize' => InitializeTenantDatabase::class, 'tenant.clear' => ClearTenantContext::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
