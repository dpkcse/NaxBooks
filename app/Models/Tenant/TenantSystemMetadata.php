<?php

namespace App\Models\Tenant;

/**
 * @deprecated Retained temporarily during the shared-schema tenancy transition.
 * Do not add new dependencies. Removal requires completion of the approved
 * transition plan and isolation tests.
 */
class TenantSystemMetadata extends TenantModel
{
    protected $table = 'tenant_system_metadata';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['provisioned_at' => 'datetime', 'last_migrated_at' => 'datetime'];
    }
}
