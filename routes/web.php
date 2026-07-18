<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\PlatformAdmin\DashboardController as PlatformAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::view('/profile', 'central.profile')->name('profile.show');
});

// Fortify owns POST /logout and performs session invalidation and CSRF-token rotation.
Route::prefix('platform')->as('platform.')->middleware(['auth', 'verified', 'platform.admin'])->group(function (): void {
    Route::get('/dashboard', PlatformAdminDashboardController::class)->name('dashboard');
});
