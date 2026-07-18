<?php
namespace App\Models\Tenant;
use App\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Model;
class TenantModel extends Model
{
    public function getConnectionName(): ?string { app(TenantContext::class)->tenant(); return config('tenancy.tenant_connection'); }
}
