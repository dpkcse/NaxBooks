<?php
use App\Enums\TenantStatus;use App\Models\Central\Tenant;use App\Services\TenantStatusTransitionService;
it('allows only explicit tenant lifecycle transitions',function(){$service=new TenantStatusTransitionService;$tenant=new Tenant;$tenant->forceFill(['status'=>TenantStatus::PendingProvisioning]);expect($service->canTransition($tenant->status,TenantStatus::Provisioning))->toBeTrue()->and($service->canTransition($tenant->status,TenantStatus::Active))->toBeFalse();});
