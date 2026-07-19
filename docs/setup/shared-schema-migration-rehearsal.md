# Shared-schema migration rehearsal — future approved execution only

1. Obtain Case A/B/C approval and record environment, commit SHA, operator, maintenance window, backup/snapshot/PITR reference, and rollback owner.
2. Run the read-only inventory commands; export central and each tenant schema (`mysqldump --no-data`) and record migration status, table DDL/indexes, counts, and checksums.
3. In a disposable clone, run `php artisan migrate:status` and the future approved migration preview/review. **Do not execute migrations as part of Step 4.**
4. During an approved Step 5 rehearsal, run only approved additive migrations/copy tooling; capture checkpoint IDs, exception report, source/target counts/checksums, defaults, FK/index checks, and timestamps.
5. Run schema, reconciliation, two-tenant isolation, route/policy, queue/context, registration, and legacy provisioning regression suites; capture application smoke evidence.
6. Rehearse rollback: stop cutover traffic, restore the prior compatible release/feature-flag path, prove legacy data is intact/read-only, and document reconciliation state. Do not use destructive rollback by default.
7. Archive evidence and obtain DBA/owner QA sign-off before advancing environments.
