<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.welcome')->name('welcome');
Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
Route::get('/health', function () {
    $database = 'unavailable';
    try { DB::connection()->getPdo(); $database = 'ok'; } catch (Throwable) { $database = 'unavailable'; }
    $cache = 'configured';
    try { Cache::store()->get('health-check'); $cache = 'ok'; } catch (Throwable) { $cache = 'unavailable'; }
    return response()->json([
        'status' => 'ok',
        'version' => config('app.version', '0.1.0'),
        'environment' => app()->environment(['local','testing']) ? app()->environment() : 'production',
        'database' => $database,
        'cache' => $cache,
        'queue' => config('queue.default'),
    ]);
})->name('health');
