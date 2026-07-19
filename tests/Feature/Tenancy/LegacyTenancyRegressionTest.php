<?php

it('retains legacy tenancy infrastructure during the transition', function (): void {
    expect(class_exists(\App\Tenancy\TenantContext::class))->toBeTrue()
        ->and(class_exists(\App\Tenancy\TenantContextManager::class))->toBeTrue()
        ->and(config('database.connections.tenant'))->toBeArray()
        ->and(config('database.connections.provisioning'))->toBeArray()
        ->and(is_dir(database_path('migrations/tenant')))->toBeTrue();

    foreach (['TenantMigrateCommand', 'TenantSeedFoundationCommand', 'TenantProvisionCommand', 'TenantRetryProvisioningCommand'] as $command) {
        expect(class_exists("App\\Console\\Commands\\{$command}"))->toBeTrue();
    }
});

it('preserves the tracked migration inventory', function (): void {
    expect(glob(database_path('migrations/tenant/*.php')))->toHaveCount(2)
        ->and(file_exists(database_path('migrations/2026_07_18_120000_create_central_tenancy_tables.php')))->toBeTrue();
});
