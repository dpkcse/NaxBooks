# Transition Step 5 test plan — not executable in Step 4

| Area | Required evidence |
|---|---|
| Schema | Each foundation table has required non-null ownership columns after cutover; FK restrict/null behavior, composite unique constraints, and tenant-leading indexes verified through schema assertions/`information_schema`. |
| Ownership | Tenant A company; A branch under A company; cross-tenant company/branch assignment rejected before persistence; currencies/settings/access/audit rows remain tenant scoped; browser `tenant_id` ignored/rejected. |
| Data migration | Per tenant/table source/target counts and deterministic checksums match; timestamps/audit payloads/defaults retained; duplicate/default/orphan/missing-owner exceptions reported; retry resumes idempotently. |
| Isolation | A cannot query, bind, mutate, bulk-update, export, cache-read, or infer B foundation rows; default switching remains tenant scoped. |
| Regression | Central users/domains/memberships remain intact; registration and legacy provisioning stay operational until their later approved cutover; database creator and tenant migration files remain present through Step 8. |

Use separate Tenant A/B fixtures, explicit trusted context setup/clear, factories that reject invalid ownership chains, migration-schema assertions on MySQL/MariaDB CI, and a failure-path suite for every reconciliation checkpoint. No test should claim isolation before Step 5 is implemented.
