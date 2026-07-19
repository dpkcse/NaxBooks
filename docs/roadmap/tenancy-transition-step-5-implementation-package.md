# Transition Step 5 implementation package — approval required

## Preconditions / acceptance gate
Owner must classify every environment, approve this package, capture backup/PITR evidence where applicable, run the read-only inventory, resolve naming collisions, and approve the Case A/B/C path. Do not start Step 5 while classification is UNKNOWN.

## Exact proposed work (not created now)
1. Create timestamped **additive** migrations in `database/migrations` (names selected at approval time to preserve ordering):
   - `add_shared_schema_tenant_ownership_to_foundation_tables`: add nullable staging ownership columns/indexes only where the canonical primary schema already holds the table; do not edit legacy migrations.
   - `enforce_shared_schema_foundation_ownership`: after verified backfill, make ownership non-null and add the FKs/unique/indexes documented in the foundation design.
   - Case A may instead rebuild explicitly approved disposable migration history; Case B/C never do.
2. Modify only `Company`, `Branch`, `Currency`, `CompanySetting`, `CompanyUserAccess`, `TenantAuditLog`, and the replacement shared model base after schema validation: guarded tenant IDs, `BelongsToTenant`, relationships, server-side create actions, scoped bindings/policies. Keep `TenantScope` inactive until a separately reviewed activation slice.
3. For Cases B/C, create an idempotent, resumable, dry-run-capable **copy/reconciliation service** with durable per-tenant checkpoints and conflict/quarantine reporting. It must not be written before case approval.
4. Feature flag any read-path cutover (`shared_schema_foundation_read_path`); dual-write is prohibited unless separately designed, tested, and approved.

## Required validation and rollback
Before non-null constraints: query null owners, duplicate composite keys, orphan company chains, multiple/missing defaults, and source/target row counts/checksums. Validate `information_schema` FKs/indexes, two-tenant isolation, route/policy behavior, timestamps, and smoke flows. Case B/C rollback is traffic/code rollback to the prior compatible release while legacy tenant databases remain read-only and intact; do not drop shared or legacy data. Acceptance requires all Step 5 tests, reconciliation exceptions resolved/approved, and owner sign-off.
