<?php
namespace App\Http\Middleware;
use App\Enums\TenantStatus; use Closure; use Illuminate\Http\Request;
final class EnsureTenantIsOperational { public function handle(Request $request, Closure $next): mixed { $tenant=$request->attributes->get('tenant_resolution')?->tenant; abort_unless($tenant && in_array($tenant->status,[TenantStatus::Trialing,TenantStatus::Active,TenantStatus::GracePeriod],true),404); return $next($request); } }
