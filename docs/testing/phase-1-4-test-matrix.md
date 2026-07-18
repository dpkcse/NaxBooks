# Phase 1.4 test matrix
MySQL/MariaDB integration validation is required locally: database creation, connection switching, tenant migrations, unique constraints, cache locking, retries, and A/B isolation. SQLite alone is not sufficient for database creation or identifier tests.

Unit coverage should assert safe deterministic names and sanitization; feature/integration coverage should assert BDT/USD idempotency, one default company/branch, owner access, checkpoint resume, failure/context clearing, and that central and tenant schemas remain separate.
