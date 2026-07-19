# Tenancy transition Steps 1–3 pre-implementation audit

**Observed:** 2026-07-19. **Branch:** `work`. This audit is a source inventory; it made no database connection, migration, data, provisioning, middleware, or runtime-context change.

## Current implementation baseline
- `App\Tenancy\TenantContext`, `TenantContextManager`, and `TenantContextException` hold a central `App\Models\Central\Tenant`; the manager purges the configured `tenant` connection, writes `database.connections.tenant.database`, and reconnects it. `TenantModel` forces that connection after context initialization.
- `App\Services\Tenancy\TenantDatabaseName`, `CreateTenantDatabase`, `TenantFoundationSeeder`, and `TenantProvisioner` calculate names, query the `provisioning` connection, issue `CREATE DATABASE`, migrate `database/migrations/tenant`, seed, and write `TenantSystemMetadata`.
- `TenantMigrateCommand`, `TenantSeedFoundationCommand`, `TenantProvisionCommand`, and `TenantRetryProvisioningCommand` remain registered by Laravel command discovery. HTTP middleware and job middleware still initialize/clear the legacy manager.
- `config/database.php` retains explicit `central`, `tenant`, and `provisioning` connections. Tenant migrations are `2026_07_18_130000_create_tenant_foundation_tables.php` and `2026_07_18_140000_add_tenant_system_metadata.php`; central migration history is untouched.

## Dependencies, collisions, and test baseline
No `CurrentTenant`, shared-schema `BelongsToTenant`, or `TenantScope` class existed. Introducing them in `App\Contracts\Tenancy`, `App\Support\Tenancy`, `App\Models\Concerns`, and `App\Models\Scopes` avoids the legacy `App\Tenancy` names. `composer.json` pins Laravel 12, PHP 8.2, Pest 3, Pint, and Larastan; vendor was unavailable at observation time. Existing tests cover central connections, authorization, context-related helpers, and provisioning-era features, but do not prove shared-schema row isolation.

## Files that must remain untouched in Steps 1–3
`config/database.php`; `bootstrap/app.php`; legacy middleware/jobs; `TenantContext` and its active behavior; `TenantProvisioner` behavior; registration/provisioning actions; every existing migration and tenant migration; connection definitions; and all tenant command signatures/behavior. Steps 4–5, not this increment, design consolidation and add additive shared-schema ownership columns.
