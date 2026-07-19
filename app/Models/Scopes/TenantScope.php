<?php

namespace App\Models\Scopes;

use App\Contracts\Tenancy\CurrentTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Inactive design scaffold. It is not registered on any model in this step.
 * A global scope is a defense-in-depth guardrail, never the sole boundary.
 */
final class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $currentTenant = app(CurrentTenant::class);
        $currentTenant->assertInitialized();

        $builder->where(
            $model->qualifyColumn(method_exists($model, 'tenantKeyName') ? $model->tenantKeyName() : 'tenant_id'),
            $currentTenant->id(),
        );
    }
}
