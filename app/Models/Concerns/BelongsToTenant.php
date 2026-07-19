<?php

namespace App\Models\Concerns;

use App\Contracts\Tenancy\CurrentTenant;
use App\Exceptions\Tenancy\TenantOwnershipMismatchException;

/**
 * Shared-schema ownership foundation; do not apply to production models yet.
 *
 * A later approved step will assign the trusted tenant ID during creation and
 * activate a query scope. Request input must never supply trusted ownership.
 */
trait BelongsToTenant
{
    public function tenantKeyName(): string
    {
        return 'tenant_id';
    }

    public function tenantId(): int
    {
        return (int) $this->getAttribute($this->tenantKeyName());
    }

    public function belongsToCurrentTenant(): bool
    {
        $currentTenant = app(CurrentTenant::class);

        return $currentTenant->isInitialized()
            && $this->tenantId() === $currentTenant->id();
    }

    public function assertBelongsToCurrentTenant(): void
    {
        $currentTenant = app(CurrentTenant::class);
        $currentTenant->assertInitialized();

        if (! $this->belongsToCurrentTenant()) {
            throw new TenantOwnershipMismatchException;
        }
    }
}
