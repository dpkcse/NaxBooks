<?php

namespace App\Support\Tenancy;

use App\Contracts\Tenancy\CurrentTenant;
use App\Exceptions\Tenancy\TenantContextConflictException;
use App\Exceptions\Tenancy\TenantContextNotInitializedException;
use App\Models\Central\Tenant;
use InvalidArgumentException;

/**
 * Scoped, trusted tenant identity for the future shared-schema path.
 *
 * This deliberately runs in parallel with the legacy TenantContext and does
 * not resolve requests, authorize memberships, or configure connections.
 */
final class CurrentTenantContext implements CurrentTenant
{
    private ?Tenant $tenant = null;

    public function setTrusted(Tenant $tenant): void
    {
        if (! $tenant->exists || ! is_int($tenant->getKey())) {
            throw new InvalidArgumentException('A persisted tenant is required.');
        }

        if ($this->tenant === null) {
            $this->tenant = $tenant;

            return;
        }

        if ($this->tenant->is($tenant)) {
            return;
        }

        throw new TenantContextConflictException;
    }

    public function id(): int
    {
        return (int) $this->model()->getKey();
    }

    public function model(): Tenant
    {
        $this->assertInitialized();

        return $this->tenant;
    }

    public function isInitialized(): bool
    {
        return $this->tenant !== null;
    }

    public function assertInitialized(): void
    {
        if (! $this->isInitialized()) {
            throw new TenantContextNotInitializedException;
        }
    }

    public function clear(): void
    {
        $this->tenant = null;
    }
}
