# Shared-schema tenancy target architecture

## Modular-monolith boundary and hierarchy
One Laravel 12 application owns platform, tenancy, company, accounting and real-estate modules; modules communicate through explicit actions/services and database transactions, not microservices. Ownership flows **Platform → Tenant → Company → Branch → Fiscal Year → Accounting Period → records**. One MySQL schema, one migration stream in `database/migrations`, one queue/cache deployment, and private object storage are used.

## Table classes and mandatory scopes
| Class | Tables | Required columns / constraints |
|---|---|---|
| Platform-global | `users`, `tenants`, `domains`, memberships, invitations, platform roles/permissions, plans, subscriptions, platform audit logs | no tenant scope for `users`/plans; tenant references where the event belongs to a tenant; globally unique tenant slug/domain |
| Tenant-owned | companies, currencies, tenant settings/roles/permissions, tenant audit logs, customers, suppliers, projects, real-estate records | `tenant_id` non-null FK/index; tenant-aware uniques; policy, scoped binding, factory |
| Company-owned | branches, company settings/access, chart accounts, parties, assets | `tenant_id`, `company_id` non-null, indexed; validate company belongs to tenant |
| Branch-owned | operational records, cash, inventory locations | `tenant_id`, `company_id`, `branch_id` as applicable; verify full chain |
| Period transactions | vouchers, ledger entries, allocations | `tenant_id`, `company_id`, optional `branch_id`, `fiscal_year_id`, `accounting_period_id`; immutable posting/audit |

`currencies` should be tenant-owned because activation/base settings are workspace decisions. `company_user_access` references a central user/membership but stores tenant and company IDs to make the ownership predicate enforceable.

## Scope and constraint rules
- The server derives `tenant_id` only from trusted `CurrentTenant`; it is guarded from request mass assignment.
- Use FKs where same-schema parent tables exist, `restrictOnDelete` for financial ownership, and composite indexes that start with tenant scope.
- Unique examples: `tenants.slug`; `companies(tenant_id, code)`; `branches(tenant_id, company_id, code)`; `vouchers(tenant_id, company_id, fiscal_year_id, number)`; accounts `(tenant_id, company_id, code)`; units `(tenant_id, project_id, unit_number)`.
- Validation mirrors, but never replaces, database uniqueness. `Rule::unique(...)->where('tenant_id', currentTenant()->id())` is the pattern.

## Tenant context API
Retain `TenantContext` as a small application-scoped state holder and introduce a `CurrentTenant` contract. Target API: `setTrusted(Tenant $tenant): void`, `id(): int|string`, `model(): Tenant`, `isInitialized(): bool`, `clear(): void`. It has no `databaseName`, config mutation, purge, or reconnect. `TenantContextManager` may be renamed `TenantContextInitializer` and only delegates trusted initialization/clear. It accepts only an exact verified domain result or an authorized server-side workspace selection; central routes intentionally have no context. HTTP, job, scheduled loop and test `finally` blocks clear it. Jobs serialize tenant ID, reload and authorize lifecycle, set context around execution.

## Data-store extension seam
Do not add a runtime strategy framework now. Keep domain actions free of `DB::connection()` and centralize future data access at module query/action boundaries. Later an internal `TenantDataStore`/`TenantStorageStrategy` may resolve `SharedSchemaTenantDataStore` or `DedicatedDatabaseTenantDataStore`; extraction is a controlled export/import, verification, cutover and rollback operation—not hybrid MVP runtime behavior.

## Database and performance rules
Index common predicates: `(tenant_id, created_at)`, `(tenant_id, status)`, `(tenant_id, company_id)`, and `(tenant_id, company_id, branch_id)` before sort/range columns. Use cursor/chunkById pagination for large jobs, eager-load known relations, prohibit unscoped joins/bulk writes, and use query objects for reports. Maintain materialized/aggregate reporting tables only after measurement; archive audit/ledger data according to retention rules. Partitioning and sharding are deferred until measured size, query plans and restore objectives justify them.

## Transition Steps 1–3 foundation
The ADR is owner-approved and database-per-tenant expansion is frozen. `App\Contracts\Tenancy\CurrentTenant` and the scoped `CurrentTenantContext` are a **parallel** trusted-identity foundation only; active middleware, jobs, provisioning, and legacy `TenantContextManager` have not switched. The context contains no connection/database/config behavior. The inactive `BelongsToTenant` trait defaults to `tenant_id`; no production model uses it and no global scope is registered. Future creation assigns the ID from trusted context in a service/action, guards it from UI input, validates company/branch chains, and fails ownership mismatches before persistence.

Defense in depth remains: (1) `CurrentTenant`, (2) `BelongsToTenant`, (3) server-side assignment, (4) `TenantScope`, (5) scoped route binding, (6) policies, (7) service assertions, (8) database constraints, and (9) isolation tests. A future `WithoutTenantScope` must be an intentionally named platform-only mechanism requiring platform authorization and an audit reason; it is not a generic `withoutGlobalScopes()` escape hatch and is not implemented now.
