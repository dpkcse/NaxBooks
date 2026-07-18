<?php
namespace App\Http\Middleware;
use App\Tenancy\TenantContextManager; use Closure; use Illuminate\Http\Request;
final class ClearTenantContext { public function handle(Request $request, Closure $next): mixed { try { return $next($request); } finally { app(TenantContextManager::class)->clear(); } } }
