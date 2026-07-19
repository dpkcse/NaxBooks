# Shared-schema tenancy test strategy

## Layers and ownership
The test engineer owns executable isolation matrices, risk-based regression and acceptance evidence; the senior developer owns unit/domain invariants; frontend owns component interaction checks; DevOps owns staging/backup/observability rehearsal. Layers: unit (context/traits/helpers), feature (routes/policies/validation), integration (migrations/jobs/storage), isolation (two tenants), accounting invariants once Phase C begins, browser smoke, measured performance, and security regression.

## Mandatory isolation matrix
For a Tenant A actor and Tenant B fixture, prove A cannot read, update, delete/archive, export, search, dashboard-aggregate, report, cache-read, file-read, route-bind, bulk-act on, or infer B’s record. Also prove request `tenant_id` spoofing is ignored/rejected, Livewire ID spoofing is rejected, jobs clear/reload context, schedules iterate explicit tenants, and platform cross-tenant action requires explicit privilege/audit. Foreign tenant route binding must return 404; normal authorization denial may remain 403 only after a scoped resource is found.

## Reusable test kit and CI gates
Provide `createTenantContext()`, `actingAsTenantOwner()`, `actingAsTenantMember()`, `assertTenantIsolation()`, `assertModelBelongsToTenant()`, `tenantFactory()`, `companyFactory()`, and `branchFactory()`. Factories require/derive valid ownership chains and fail loudly on mismatches. Run focused unit/feature tests per change; CI runs full tests, Pint, PHPStan, frontend build and migration status in disposable CI infrastructure. Browser smoke covers login, selection, scoped list/form/error/loading states. Performance tests establish report/list baselines only after representative data exists; do not invent throughput targets.

## Steps 1–3 focused baseline
This increment supplies explicit `CreatesTenantContext` helpers for context-only tests: `createTenantContext`, `clearTenantContext`, `assertCurrentTenant`, and `assertNoCurrentTenant`. It intentionally does not add membership helpers or shared-schema factories because ownership columns do not exist yet. Tests cover uninitialized/conflicting/idempotent context behavior, ownership comparisons, safe public errors, no connection mutation in the new context, inactive scope status, and retained legacy configuration/commands/migrations. This is not yet proof of complete shared-schema isolation.
