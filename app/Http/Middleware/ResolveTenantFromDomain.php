<?php
namespace App\Http\Middleware;
use App\Services\Tenancy\ResolveTenantFromHost;
use Closure; use Illuminate\Http\Request;
final class ResolveTenantFromDomain { public function handle(Request $request, Closure $next): mixed { $result=app(ResolveTenantFromHost::class)($request->getHost()); if(!$result->foundTenant()) abort(404); $request->attributes->set('tenant_resolution',$result); return $next($request); } }
