# Future dedicated-tenant-database extension

The MVP implements **only** shared schema. Preserve one seam: domain actions must receive trusted tenant context and must not call `DB::connection()` or switch configuration. A future internal `TenantDataStore`/`TenantStorageStrategy` can expose scoped query/transaction/storage capabilities, with `SharedSchemaTenantDataStore` first and `DedicatedDatabaseTenantDataStore` later. Do not create these abstractions until a real enterprise requirement needs them.

Enterprise admission requires a signed isolation requirement, cost model, migration/export checksum plan, encrypted backup/restore target, monitoring, schema release process, tenant cutover window, rollback window, and test environment. Business contracts and identifiers remain stable. No hybrid runtime, tenant connection resolver, or parallel migration fleet is introduced in this audit.
