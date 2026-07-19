<?php

use App\Contracts\Tenancy\BelongsToTenant as BelongsToTenantContract;
use App\Contracts\Tenancy\CurrentTenant;
use App\Exceptions\Tenancy\TenantContextNotInitializedException;
use App\Exceptions\Tenancy\TenantOwnershipMismatchException;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Tests\Concerns\CreatesTenantContext;

uses(CreatesTenantContext::class);

afterEach(fn () => $this->clearTenantContext());

function tenantOwnedTestModel(int $tenantId): Model&BelongsToTenantContract {
    return new class(['tenant_id' => $tenantId]) extends Model implements BelongsToTenantContract {
        use BelongsToTenant;
    };
}

it('uses tenant_id as the default ownership key and recognizes trusted ownership', function (): void {
    $this->createTenantContext(10);
    $model = tenantOwnedTestModel(10);

    expect($model->tenantKeyName())->toBe('tenant_id')
        ->and($model->tenantId())->toBe(10)
        ->and($model->belongsToCurrentTenant())->toBeTrue();
});

it('rejects foreign ownership without disclosing tenant identifiers', function (): void {
    $this->createTenantContext(10);
    $model = tenantOwnedTestModel(20);

    expect($model->belongsToCurrentTenant())->toBeFalse();
    try {
        $model->assertBelongsToCurrentTenant();
    } catch (TenantOwnershipMismatchException $exception) {
        expect($exception->getMessage())->not->toContain('10')->not->toContain('20');

        return;
    }

    $this->fail('Expected a tenant ownership mismatch.');
});

it('fails closed when no current tenant exists', function (): void {
    expect(fn () => tenantOwnedTestModel(10)->assertBelongsToCurrentTenant())
        ->toThrow(TenantContextNotInitializedException::class);
});

it('does not allow request-style ownership input to replace trusted context', function (): void {
    $this->createTenantContext(10);
    $requestStyleAttributes = ['tenant_id' => 20];
    $model = tenantOwnedTestModel($requestStyleAttributes['tenant_id']);

    expect(app(CurrentTenant::class)->id())->toBe(10)
        ->and($model->belongsToCurrentTenant())->toBeFalse();
});

it('does not apply the trait or a tenant scope to existing production models', function (): void {
    expect(in_array(BelongsToTenant::class, class_uses_recursive(\App\Models\Tenant\Company::class), true))->toBeFalse()
        ->and(class_uses_recursive(\App\Models\Tenant\Company::class))->not->toContain(\App\Models\Scopes\TenantScope::class);
});
