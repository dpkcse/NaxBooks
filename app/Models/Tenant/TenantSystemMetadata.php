<?php

namespace App\Models\Tenant;

class TenantSystemMetadata extends TenantModel
{
    protected $table = 'tenant_system_metadata';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['provisioned_at' => 'datetime', 'last_migrated_at' => 'datetime'];
    }
}
