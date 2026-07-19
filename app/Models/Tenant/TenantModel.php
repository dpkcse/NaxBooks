<?php
namespace App\Models\Tenant;
use App\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Model;
/**
 * @deprecated Retained temporarily during the shared-schema tenancy transition.
 * Do not add new dependencies. Removal requires completion of the approved
 * transition plan and isolation tests.
 */
class TenantModel extends Model
{
    public function getConnectionName(): ?string { app(TenantContext::class)->tenant(); return config('tenancy.tenant_connection'); }
}
