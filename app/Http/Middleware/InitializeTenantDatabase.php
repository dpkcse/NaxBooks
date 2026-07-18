<?php
namespace App\Http\Middleware;
use App\Tenancy\TenantContextManager; use Closure; use Illuminate\Http\Request;
final class InitializeTenantDatabase { public function handle(Request $request, Closure $next): mixed { app(TenantContextManager::class)->initialize($request->attributes->get('tenant_resolution')->tenant); return $next($request); } }
