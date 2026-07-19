# NAXAS AI SME Accounting & Real Estate Management SaaS

This repository currently contains the **Phase 1.2 central authentication and tenancy metadata foundation**. It does not yet implement tenant database switching, provisioning execution, accounting, real estate, subscriptions, or billing.

## Database target

The platform's `central` connection owns central users, tenants, domains, memberships, invitations, provisioning diagnostics, and immutable platform audit logs. Local development supports MariaDB 10.4.32+; production targets MySQL 8+. Configure `CENTRAL_DB_CONNECTION`, `CENTRAL_DB_HOST`, `CENTRAL_DB_PORT`, `CENTRAL_DB_DATABASE`, `CENTRAL_DB_USERNAME`, `CENTRAL_DB_PASSWORD`, and optional `CENTRAL_DB_SOCKET`.

For a disposable local Phase 1.2 database, `DB_*` and `CENTRAL_DB_*` may intentionally point to the same database. See [local development](docs/setup/local-development.md), [central database architecture](docs/architecture/central-database.md), and the [recovery audit](docs/audits/phase-1-2-recovery-audit.md).

## Validation

Run Composer dependency installation/resolution, non-destructive migration preview, Laravel tests, Pint, PHPStan, and the frontend build before deployment. MariaDB/MySQL migration validation must not be inferred from SQLite.

## Phase 1.3 tenancy foundation
Phase 1.3 introduces exact verified-domain resolution, a runtime tenant connection context, and isolated cache/job/file helpers. It deliberately does **not** provision tenant databases or create business modules. See [local tenancy setup](docs/setup/local-tenancy-development.md) and the [Phase 1.3 completion report](docs/audits/phase-1-3-completion-report.md).

## Tenant provisioning (Phase 1.4)
Tenant provisioning is explicitly scoped and never performs database deletion. See [local tenant provisioning](docs/setup/local-tenant-provisioning.md) for required separate credentials and validation commands. The current source is conditional on local MySQL/MariaDB runtime verification.

## Shared-schema tenancy transition (Steps 1–3)
The owner accepted the shared-schema MVP ADR. New database-per-tenant feature expansion is frozen while the legacy tenant/provisioning connections, runtime switching, commands, migrations, middleware, and provisioning behavior remain temporarily active. This release adds a parallel scoped `CurrentTenant` and inactive ownership foundation only; it changes no migrations, data, connection definitions, or provisioning behavior. Revert the single transition commit with `git revert <commit>` if required—no database restore, migration rollback, environment change, or data repair is needed. Transition Steps 4–5 (migration-consolidation design, then separately approved additive ownership schema work) are next.

## Shared-schema migration design (Step 4)
Step 4 completed only audit/design/rehearsal documentation. No schema changed, migration was added, data was moved, connection changed, or runtime/provisioning cutover occurred. The environment case is **UNKNOWN** from repository evidence; Step 5 is NO-GO until the owner executes the [read-only migration inventory](docs/setup/tenancy-migration-inventory-commands.md), classifies each environment, and approves the [Step 5 implementation package](docs/roadmap/tenancy-transition-step-5-implementation-package.md).
