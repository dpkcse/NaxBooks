# Tenancy simplification transition plan

No step starts without an approved ADR, non-production rehearsal, change review, and case classification. Preserve deprecated code until references are removed and rollback is rehearsed.

| Step | Likely files / prerequisites | Risk and rollback | Tests / acceptance |
|---|---|---|---|
| 1 Freeze DB-per-tenant features | roadmap, issue policy; owner approval | drift; revert only documentation freeze | no new tenant DB commands/features accepted |
| 2 ADR and deprecation markers | ADR, config/docs, command notices | operator confusion; restore prior docs | reference map approved |
| 3 ownership contracts | new contract/trait/scope/exception/factories; no behavior cutover | accidental global-scope masking; feature flag/remove unused code | unit and two-tenant model tests |
| 4 consolidate foundation migration design | central/tenant migration inventory | applied-history damage; do not edit applied production migrations | selected Case A/B/C rehearsal and schema diff |
| 5 add ownership columns/tables | corrective migrations/models/indexes | locks/data mismatch; additive migration and backup | FK/index/backfill/row-count validation |
| 6 simplify context | context/manager/middleware/jobs/models | worker leakage; retain rollback release and clear in finally | HTTP/job/Livewire context tests, no purge/reconnect calls |
| 7 onboarding service | provisioner/action/UI/audit/seed | partial onboarding; transaction + idempotency checkpoint | create/retry/failure/after-commit tests |
| 8 retire DB creation/migration execution | config/services/commands/tenant migrations | missed reference; keep deprecated code until audit | repository reference search and deployment rehearsal |
| 9 registration/status commands/UI | routes/controllers/Livewire | lifecycle regression; previous compatible release | browser/feature flows |
| 10 isolation suite | tests/helpers/CI | false confidence; use independent fixtures | mandatory matrix green |
| 11 remove deprecated code | only verified unused paths | irreversible deletion; tag/release and backup first | zero reference search, full suite |
| 12 setup/deployment/SRS | README/env/docs/runbooks | stale operations; revert docs if needed | operator walkthrough |

## Migration consolidation cases
**A — disposable local/no production data:** migrations may be edited before first shared use; rebuild only a disposable database under developer control (never use destructive commands in this audit); validate fresh schema/status and tests.

**B — shared/staging development data:** do not edit applied migrations. Add corrective additive migrations, create shared foundation tables, copy/reconcile only after backup, use temporary parallel tables if names collide, validate counts/checksums/FKs and retain old tenant DBs/read-only rollback window.

**C — production exists:** never edit applied history; require DBA-approved backup/PITR, production inventory, dry-run rehearsal, resumable copy with checksums, dual-read only if explicitly designed, maintenance/cutover plan, tenant-by-tenant validation, and tested restore. Parallel tables are justified only for incompatible schemas; rollback is traffic/code rollback before cutover or approved restore/forward correction after writes.

## Steps 1–3 completion boundary
Steps 1–3 are complete as a reversible, one-commit foundation: approval, freeze, non-destructive deprecations, parallel scoped context, inactive ownership primitives, tests, and documentation. **Step 4 next:** inventory/consolidation design and non-production rehearsal; do not alter applied history. **Step 5 next after separate approval:** additive `tenant_id` ownership schema, indexes/constraints, controlled backfill/cutover design, and two-tenant isolation evidence. No runtime switching or provisioning removal is authorized before later steps.

## Step 4 completion
Step 4 is documentation-first and non-destructive: migration/foundation inventory, UNKNOWN environment case classification, collision and data mapping design, and a future rehearsal package are complete. No Step 5 migration, schema, data copy, model adoption, scope activation, or runtime cutover was performed. Step 5 is owner-approval gated by read-only runtime inventory and Case A/B/C confirmation.
