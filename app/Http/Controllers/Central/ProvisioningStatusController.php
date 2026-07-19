<?php
namespace App\Http\Controllers\Central;
use App\Http\Controllers\Controller; use App\Models\Central\Tenant; use Illuminate\Http\Request;
class ProvisioningStatusController extends Controller {
 public function __invoke(Request $request,Tenant $tenant){abort_unless($request->user()&&$tenant->memberships()->where('user_id',$request->user()->id)->where('status','active')->exists(),403);$attempt=$tenant->provisioningAttempts()->latest('attempt_number')->first();return view('central.provisioning-status',compact('tenant','attempt'));}
}
