<?php
namespace App\Http\Controllers\Central;
use App\Http\Controllers\Controller;use Illuminate\Http\Request;
class DashboardController extends Controller{public function __invoke(Request $request){return view('central.dashboard',['memberships'=>$request->user()->activeTenantMemberships()->with('tenant')->get()]);}}
