<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
final class TenantDashboardController extends Controller { public function __invoke(Request $request) { return view('tenant.dashboard',['tenant'=>$request->attributes->get('tenant_resolution')->tenant,'membership'=>$request->attributes->get('tenant_membership'),'domain'=>$request->attributes->get('tenant_resolution')->host,'user'=>$request->user()]); } }
