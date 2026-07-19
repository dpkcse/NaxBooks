<?php

use App\Contracts\Tenancy\CurrentTenant;
use App\Exceptions\Tenancy\TenantContextConflictException;
use App\Exceptions\Tenancy\TenantContextNotInitializedException;
use App\Models\Central\Tenant;
use App\Support\Tenancy\CurrentTenantContext;
use Tests\Concerns\CreatesTenantContext;

uses(CreatesTenantContext::class);

afterEach(fn () => $this->clearTenantContext());

it('starts uninitialized and fails safely when read', function (): void {
    $context = app(CurrentTenant::class);

    expect($context->isInitialized())->toBeFalse();
    expect(fn () => $context->id())->toThrow(TenantContextNotInitializedException::class);
    expect(fn () => $context->model())->toThrow(TenantContextNotInitializedException::class);
});

it('accepts a persisted tenant and returns its trusted identity', function (): void {
    $tenant = $this->createTenantContext(41);

    expect(app(CurrentTenant::class)->id())->toBe(41)
        ->and(app(CurrentTenant::class)->model())->toBe($tenant);
});

it('rejects an unsaved tenant', function (): void {
    expect(fn () => app(CurrentTenant::class)->setTrusted(new Tenant))->toThrow(InvalidArgumentException::class);
});

it('is idempotent for the same tenant and conflicts for another tenant', function (): void {
    $tenant = $this->createTenantContext(41);
    app(CurrentTenant::class)->setTrusted($tenant);

    $other = new Tenant;
    $other->setRawAttributes(['id' => 42], true);
    $other->exists = true;

    expect(fn () => app(CurrentTenant::class)->setTrusted($other))->toThrow(TenantContextConflictException::class);
});

it('clears idempotently', function (): void {
    $this->createTenantContext();
    $this->clearTenantContext();
    $this->clearTenantContext();

    $this->assertNoCurrentTenant();
});

it('uses the scoped shared-schema context without mutating legacy connection configuration', function (): void {
    $before = config('database.connections');
    $source = file_get_contents(app_path('Support/Tenancy/CurrentTenantContext.php'));

    $this->createTenantContext();

    expect(app(CurrentTenant::class))->toBeInstanceOf(CurrentTenantContext::class)
        ->and(config('database.connections'))->toBe($before)
        ->and($source)->not->toContain('purge(')
        ->and($source)->not->toContain('reconnect(')
        ->and($source)->not->toContain('databaseName')
        ->and($source)->not->toContain('config(');
});
