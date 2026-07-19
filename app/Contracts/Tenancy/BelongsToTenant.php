<?php

namespace App\Contracts\Tenancy;

interface BelongsToTenant
{
    public function tenantKeyName(): string;

    public function tenantId(): int;

    public function belongsToCurrentTenant(): bool;

    public function assertBelongsToCurrentTenant(): void;
}
