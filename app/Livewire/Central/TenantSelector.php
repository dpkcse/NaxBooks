<?php
namespace App\Livewire\Central;
use Illuminate\Support\Facades\Auth;use Livewire\Component;
class TenantSelector extends Component{public function render(){return view('livewire.central.tenant-selector',['memberships'=>Auth::user()?->activeTenantMemberships()->with('tenant')->get() ?? collect()]);}}
