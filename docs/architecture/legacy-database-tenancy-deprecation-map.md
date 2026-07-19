# Legacy database-per-tenant deprecation map

## Freeze policy
No new feature may depend on tenant database switching, call `DB::connection('tenant')`, require `CREATE DATABASE`, add tenant migration commands, or add files below `database/migrations/tenant`. The listed legacy runtime remains operational only for transition compatibility. Removal follows shared-schema migration, isolation tests, and the approved transition plan.

| Component | Current responsibility / consumers | Target replacement | Status / removal prerequisite | Step | Risk / required tests |
|---|---|---|---|---|---|
| `config/database.php` `tenant` connection | Null-db template used by legacy models/manager | shared primary schema | Deprecated; retain until legacy callers are gone | 8/11 | Worker leakage; configuration regression test |
| `provisioning` connection | `CreateTenantDatabase` `INFORMATION_SCHEMA`/creation | none for MVP onboarding | Deprecated; no active consumers | 8/11 | Accidental create; command/reference checks |
| `TenantContextManager` mutation | middleware, jobs, provisioner, commands purge/set/reconnect | parallel `CurrentTenant`, later cutover | Deprecated; no middleware/job cutover yet | 6 | Context/worker regression |
| `TenantModel` forced connection | tenant foundation models | shared models using ownership trait | Deprecated; additive schema and model conversion required | 5/6 | No accidental model adoption |
| `TenantDatabaseName` / `CreateTenantDatabase` | registration/provisioner naming and DB creation | no MVP equivalent | Deprecated; onboarding replacement tested | 7/8 | No new create dependency |
| `TenantSystemMetadata` / ownership marker | provisioner validates tenant DB ownership | shared-schema migration metadata if approved | Deprecated; legacy provisioning retired | 8/11 | Provisioning behavior unchanged |
| `TenantProvisioner` database methods | registration and provision/retry commands | transactional shared-schema onboarding | Deprecated; approved Step 7 implementation | 7 | Idempotency/lifecycle tests |
| `TenantMigrateCommand`, `TenantSeedFoundationCommand` | explicit legacy DB migration/seed | primary migration stream | Deprecated; no tenant fleet and migration rehearsal | 8/11 | Commands still present |
| `TenantProvisionCommand`, `TenantRetryProvisioningCommand` | invokes legacy provisioner | future onboarding command/service | Deprecated; workflow replacement accepted | 7/8 | Commands and provisioning preserved |
| `database/migrations/tenant` and foundation seeder | legacy tenant schema/foundation data | normal migration stream after Steps 4–5 | Deprecated; applied-history inventory and isolation tests | 4/8/11 | Directory/files unchanged |
| purge/reconnect behavior | legacy manager recovery/clear | no runtime switching in target | Deprecated; legacy path retained until cutover | 6/11 | Existing behavior regression |
