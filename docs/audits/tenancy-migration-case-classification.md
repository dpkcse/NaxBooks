# Tenancy migration environment case classification

## Result: UNKNOWN — Step 5 NO-GO
Repository evidence shows only source configuration defaults and legacy tenant-database code. It does not establish deployment status, applied migration state, tenant database existence, table row counts, backups/PITR, or data criticality. It is unsafe to infer Case A from a local repository or Case B/C from migration files.

## Confirmation criteria
- **Case A:** owner confirms no production/staging data requiring preservation and every affected database is disposable.
- **Case B:** owner confirms shared development/staging data must be retained; use additive migrations and a controlled copy/reconciliation plan.
- **Case C:** owner confirms live users/operational tenant data; require DBA-approved backup/PITR, rehearsal, resumable per-tenant copy, maintenance/cutover and communications.

Run every read-only command in [local inventory commands](../setup/tenancy-migration-inventory-commands.md), capture output, classify each environment separately, and obtain owner approval before Step 5. The strictest confirmed environment governs release practice.
