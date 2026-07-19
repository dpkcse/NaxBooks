<?php

namespace App\Contracts\Tenancy;

use App\Models\Central\Tenant;

interface CurrentTenant
{
    public function setTrusted(Tenant $tenant): void;

    public function id(): int;

    public function model(): Tenant;

    public function isInitialized(): bool;

    public function assertInitialized(): void;

    public function clear(): void;
}
