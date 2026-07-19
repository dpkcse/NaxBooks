<?php
namespace App\Tenancy;
use App\Models\Central\Tenant;
/**
 * @deprecated Retained temporarily during the shared-schema tenancy transition.
 * Do not add new dependencies. Removal requires completion of the approved
 * transition plan and isolation tests.
 */
final class TenantContext
{
    private ?Tenant $tenant = null;
    public function initialize(Tenant $tenant): void { if ($this->tenant && $this->tenant->getKey() !== $tenant->getKey()) throw new TenantContextException('Tenant context is already initialized.'); $this->tenant = $tenant; }
    public function clear(): void { $this->tenant = null; }
    public function initialized(): bool { return $this->tenant !== null; }
    public function tenant(): Tenant { return $this->tenant ?? throw new TenantContextException('Tenant context is not initialized.'); }
    public function id(): int|string { return $this->tenant()->getKey(); }
    public function databaseName(): string { return (string) $this->tenant()->database_name; }
}
