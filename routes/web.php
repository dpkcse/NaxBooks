<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\PlatformAdmin\DashboardController as PlatformAdminDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::view('/profile', 'central.profile')->name('profile.show');
});

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::prefix('platform')->as('platform.')->middleware(['auth', 'verified', 'platform.admin'])->group(function () {
    Route::get('/dashboard', PlatformAdminDashboardController::class)->name('dashboard');
});
