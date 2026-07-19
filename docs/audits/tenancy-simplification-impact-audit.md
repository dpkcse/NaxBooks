# Tenancy Simplification Impact Audit

**Date:** 2026-07-19. **Scope:** non-destructive architecture audit; no code, migration, tenant data, or database was changed. The `work` branch is an internal sandbox observation, not evidence of the owner's branch.

## Baseline and evidence
The application is Laravel 12 with PHP pinned to 8.2.12, Fortify, Livewire 4, Blade/Alpine/Tailwind/Vite, Pest and Larastan. Phase reports record Phase 1.2 central identity, Phase 1.3 runtime context, and Phase 1.4 provisioning/foundation work. The repository uses a `central` connection for platform tables and a dynamically configured `tenant` connection. `TenantContextManager` mutates `database.connections.tenant.database`, purges and reconnects it. A provisioning connection queries `INFORMATION_SCHEMA` and issues `CREATE DATABASE`. Tenant migrations live under `database/migrations/tenant`.

## Current architecture inventory
| Area / item | Current files, classes, tables | Purpose and dependencies | Business / infrastructure value | Risk | Recommendation |
|---|---|---|---|---|---|
| Central identity | `users`; `User`; Fortify provider/actions | Shared login, verified/active user; central connection | High / high | Low | KEEP |
| Tenant registry/lifecycle | `tenants`, `Tenant`, `TenantStatus`, status service | Workspace identity, owner, lifecycle, database name | High / high | Medium: remove DB identity carefully | REFACTOR |
| Domains | `domains`, `Domain`, `ResolveTenantFromHost`, `NormalizeHost` | Exact verified-domain lookup | High / medium | Low | KEEP |
| Membership/invitations | `tenant_memberships`, `tenant_invitations`, models, membership middleware | Workspace access and ownership | High / medium | Low | KEEP |
| Attempts/audit | `provisioning_attempts`, `platform_audit_logs`, services | Retry checkpoints and redacted central audit | Medium / high | Medium | REFACTOR |
| Platform auth | `is_platform_admin`, middleware/controller | Explicit platform-only administration | High / medium | Medium | KEEP |
| Context | `TenantContext`, `TenantContextManager`, exception | Holds tenant and switches connection | High / very high | Very High leakage/worker risk | REFACTOR |
| HTTP lifecycle | resolve, operational, membership, initialize, clear middleware; tenant route | Resolve host, authorize, initialize/clear | High / high | High ordering dependency | REFACTOR |
| Livewire | registration and selector components | Central registration/selection; no tenant business components yet | Medium / medium | Medium | REFACTOR |
| Tenant database template | `config/database.php` `tenant` | Runtime per-tenant connection | None / high | Very High operations | DEPRECATE |
| Provisioning connection | `provisioning`, env variables | Least-privileged database creation | None / high | High security/ops | DEPRECATE |
| DB name and creator | `TenantDatabaseName`, `CreateTenantDatabase` | deterministic names, `INFORMATION_SCHEMA`, `CREATE DATABASE` | None / high | Very High | REMOVE LATER |
| Migration fleet | tenant migrations, `TenantMigrateCommand` | Per-tenant schema deployment | Medium / very high | Very High | DEPRECATE |
| Ownership marker | `TenantSystemMetadata` | Detect database ownership/schema | None / high | High | REMOVE LATER |
| Foundation seeding | `TenantFoundationSeeder` | BDT/USD and tenant audit in selected DB | High / medium | Medium | REFACTOR |
| Provisioning | `TenantProvisioner`, commands, registration action/UI | lock, checkpoint, create/migrate/seed/default company | High / very high | Very High | REPLACE |
| Jobs | `TenantAwareJob`, initialization middleware | Carries tenant ID and cleans context | High / high | Medium | REFACTOR |
| Cache/files | `TenantCacheKey`, `TenantPrivatePath` | tenant-prefixed keys/private paths | High / medium | Low | KEEP |
| Sessions/queues | central DB config and Laravel tables | shared infrastructure | High / medium | Low | REFACTOR configuration |
| Tenant foundation | tenant `companies`, `branches`, `currencies`, settings/access/audit; models/policy | core company structure | High / medium | High data migration | REFACTOR |

## Dependency map and quantified complexity
Registration creates central user/tenant/domain/membership then calls the provisioner. The provisioner locks, changes lifecycle, creates a database, switches context, validates marker, runs tenant migrations, seeds, creates company/branch/access, updates checkpoints, and audits. HTTP needs six ordered tenant middleware steps; jobs repeat context switching. Four Artisan commands operate a tenant database. Two migration streams and at least three DB connection profiles must remain compatible. This adds database privileges, schema-fleet deployment, backup catalog, rollback and incident paths per tenant before any accounting feature exists.

## Complexity findings
Database-per-tenant provides strong physical separation but concentrates risk in provisioning, upgrades, worker state, and restore operations. It is disproportionate for the stated four-person team. Existing domain, membership, lifecycle, audit redaction, lock/checkpoint, cache/file naming, and business foundation are reusable. Connection mutation, DB creation, metadata marker, and migration fleet are not MVP business value.

## Decision gates
| Gate | Decision | Evidence / prerequisite |
|---|---|---|
| 1 shared schema recommended | **GO** | reduces identified fleet and switching complexity; use mandatory isolation controls |
| 2 retain Phase 1.2 identity | **GO** | central users, Fortify, membership tables are directly reusable |
| 3 retain Phase 1.3 domain/context | **CONDITIONAL GO** | retain trusted exact-domain resolution; remove DB mutation and revise middleware/tests |
| 4 migrate Phase 1.4 foundation | **CONDITIONAL GO** | schemas need tenant IDs, unique/index changes, and data plan |
| 5 production migration required | **CONDITIONAL GO** | only if real tenant databases/data exist; inventory proves status before implementation |
| 6 refactor can start | **CONDITIONAL GO** | approve ADR, backup/restore rehearsal, migration case selection, and isolation suite first |

## Remaining unknowns and recommended next task
No running database inventory was performed, so applied migration state, real tenant databases, production status, and backup RPO/RTO are unknown. Next exact implementation scope: **“Implement Transition Steps 1–3 only: add deprecation notices to tenancy docs/config, introduce `CurrentTenant`/`BelongsToTenant` contracts and tests without changing connections, migrations, provisioning behavior, or deleting code.”**
