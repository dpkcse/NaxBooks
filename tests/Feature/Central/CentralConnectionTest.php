<?php
use App\Models\Central\{Domain,PlatformAuditLog,ProvisioningAttempt,Tenant,TenantInvitation,TenantMembership};use App\Models\User;
it('pins every central model to the central connection',function(){foreach([User::class,Tenant::class,Domain::class,TenantMembership::class,TenantInvitation::class,ProvisioningAttempt::class,PlatformAuditLog::class] as $model){expect((new $model)->getConnectionName())->toBe('central');}});
