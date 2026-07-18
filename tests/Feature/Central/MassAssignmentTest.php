<?php
use App\Enums\TenantStatus;use App\Models\Central\Tenant;
it('does not mass assign tenant lifecycle status from forms',function(){$tenant=new Tenant(['name'=>'Acme','slug'=>'acme','database_name'=>'tenant_acme','status'=>TenantStatus::Active->value]);expect($tenant->status)->toBeNull();});
