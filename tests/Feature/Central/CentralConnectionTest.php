<?php

use App\Models\Central\Domain;
use App\Models\Central\PlatformAuditLog;
use App\Models\Central\ProvisioningAttempt;
use App\Models\Central\Tenant;
use App\Models\Central\TenantInvitation;
use App\Models\Central\TenantMembership;
use App\Models\User;

it('defines and pins every central model to the central connection', function (): void {
    expect(config('database.connections.central'))->toBeArray();

    foreach ([User::class, Tenant::class, Domain::class, TenantMembership::class, TenantInvitation::class, ProvisioningAttempt::class, PlatformAuditLog::class] as $model) {
        expect((new $model)->getConnectionName())->toBe('central');
    }
});
