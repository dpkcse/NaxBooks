# NAXAS AI SME Accounting & Real Estate Management SaaS

This repository currently contains the **Phase 1.2 central authentication and tenancy metadata foundation**. It does not yet implement tenant database switching, provisioning execution, accounting, real estate, subscriptions, or billing.

## Database target

The platform's `central` connection owns central users, tenants, domains, memberships, invitations, provisioning diagnostics, and immutable platform audit logs. Local development supports MariaDB 10.4.32+; production targets MySQL 8+. Configure `CENTRAL_DB_CONNECTION`, `CENTRAL_DB_HOST`, `CENTRAL_DB_PORT`, `CENTRAL_DB_DATABASE`, `CENTRAL_DB_USERNAME`, `CENTRAL_DB_PASSWORD`, and optional `CENTRAL_DB_SOCKET`.

For a disposable local Phase 1.2 database, `DB_*` and `CENTRAL_DB_*` may intentionally point to the same database. See [local development](docs/setup/local-development.md), [central database architecture](docs/architecture/central-database.md), and the [recovery audit](docs/audits/phase-1-2-recovery-audit.md).

## Validation

Run Composer dependency installation/resolution, non-destructive migration preview, Laravel tests, Pint, PHPStan, and the frontend build before deployment. MariaDB/MySQL migration validation must not be inferred from SQLite.

## Phase 1.3 tenancy foundation
Phase 1.3 introduces exact verified-domain resolution, a runtime tenant connection context, and isolated cache/job/file helpers. It deliberately does **not** provision tenant databases or create business modules. See [local tenancy setup](docs/setup/local-tenancy-development.md) and the [Phase 1.3 completion report](docs/audits/phase-1-3-completion-report.md).
