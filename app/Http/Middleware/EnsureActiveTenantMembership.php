<?php
namespace App\Http\Middleware;
use App\Enums\MembershipStatus; use App\Models\Central\TenantMembership; use Closure; use Illuminate\Http\Request;
final class EnsureActiveTenantMembership { public function handle(Request $request, Closure $next): mixed { $tenant=$request->attributes->get('tenant_resolution')->tenant; $membership=TenantMembership::query()->where('tenant_id',$tenant->getKey())->where('user_id',$request->user()->getAuthIdentifier())->where('status',MembershipStatus::Active)->first(); abort_unless($membership,403); $request->attributes->set('tenant_membership',$membership); return $next($request); } }
