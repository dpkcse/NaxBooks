<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\ProvisioningStatusController;
use App\Livewire\Auth\RegisterTenant;
use App\Http\Controllers\PlatformAdmin\DashboardController as PlatformAdminDashboardController;
use App\Http\Controllers\TenantDashboardController;
use Illuminate\Support\Facades\Route;

// Platform routes are host-constrained and cannot initialize tenant context.
Route::domain(config('tenancy.central_domains.0'))->group(function (): void {
    Route::view('/', 'welcome')->name('home');
    Route::get('/register-business', RegisterTenant::class)->middleware('throttle:10,1')->name('business.register');
    Route::get('/register-business/provisioning/{tenant}', ProvisioningStatusController::class)->middleware(['auth','throttle:30,1'])->name('business.provisioning');
    Route::middleware(['auth', 'verified'])->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::view('/profile', 'central.profile')->name('profile.show');
    });
});
Route::domain(config('tenancy.admin_domains.0'))->prefix('platform')->as('platform.')->middleware(['auth', 'verified', 'platform.admin'])->group(function (): void {
    Route::get('/dashboard', PlatformAdminDashboardController::class)->name('dashboard');
});

// The host is only an input to exact central-domain resolution; it is never tenant identity itself.
Route::domain('{tenantHost}')->middleware(['tenant.resolve', 'tenant.operational', 'auth', 'verified', 'tenant.membership', 'tenant.initialize', 'tenant.clear'])->group(function (): void {
    Route::get('/dashboard', TenantDashboardController::class)->name('tenant.dashboard');
});
