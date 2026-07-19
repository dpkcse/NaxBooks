<?php

namespace Tests\Concerns;

use App\Contracts\Tenancy\CurrentTenant;
use App\Models\Central\Tenant;

trait CreatesTenantContext
{
    protected function createTenantContext(int $id = 1): Tenant
    {
        $tenant = new Tenant;
        $tenant->setRawAttributes(['id' => $id], true);
        $tenant->exists = true;

        app(CurrentTenant::class)->setTrusted($tenant);

        return $tenant;
    }

    protected function clearTenantContext(): void
    {
        app(CurrentTenant::class)->clear();
    }

    protected function assertCurrentTenant(Tenant $tenant): void
    {
        $this->assertTrue(app(CurrentTenant::class)->isInitialized());
        $this->assertSame($tenant->getKey(), app(CurrentTenant::class)->id());
    }

    protected function assertNoCurrentTenant(): void
    {
        $this->assertFalse(app(CurrentTenant::class)->isInitialized());
    }
}
