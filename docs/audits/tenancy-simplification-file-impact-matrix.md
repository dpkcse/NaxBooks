# Tenancy simplification file impact matrix

Implementation phases refer to the transition plan. Actions are planned, not performed by this audit.

| File / group | Current responsibility | Target responsibility | Action | Dependencies | Phase | Risk / required test |
|---|---|---|---|---|---|---|
| `config/database.php` | `central`, dynamic `tenant`, `provisioning` connections | primary shared DB; no tenant/provisioning connection | DEPRECATE then remove later | context, models, commands | 2, 8 | High; config/route/job smoke |
| `.env.example` | central/provisioning/tenant credentials | one primary DB and shared queue/cache settings | REFACTOR | deployment docs | 12 | Medium; example config review |
| `config/cache.php`, `queue.php`, `session.php`, `filesystems.php` | central infrastructure defaults | shared infrastructure plus scoped names/paths | REFACTOR | helpers/jobs | 6, 12 | Medium; cache/job/file tests |
| `app/Tenancy/TenantContext.php` | tenant model plus DB name | trusted current tenant only | REFACTOR | models/helpers | 6 | High; lifecycle/worker tests |
| `TenantContextManager.php` | config mutation/purge/reconnect | trusted initialize/clear only, possibly renamed | REPLACE | middleware/jobs | 6 | Very High; no connection mutation assertion |
| `TenantContextException.php` | missing/conflicting context errors | same | KEEP | context | 6 | Low; unit |
| `TenantModel.php` | forces `tenant` connection | `BelongsToTenant`-based shared model base or retire | REPLACE | all tenant models | 3, 5 | Very High; tenant scope tests |
| `ResolveTenantFromHost.php`, `NormalizeHost.php`, result | verified exact domain resolution | same trusted source | KEEP | Domain | 6 | Low; host tests |
| `ResolveTenantFromDomain.php` | stores domain resolution | initialize trusted context | REFACTOR | routes | 6 | Medium; 404 tests |
| `InitializeTenantDatabase.php` | switches DB | initialize context; rename | REPLACE | context | 6 | High; middleware ordering |
| membership/lifecycle/clear middleware | membership/lifecycle and cleanup | same, null-safe/context-first cleanup | REFACTOR | routes/jobs | 6 | Medium; feature tests |
| `TenantAwareJob.php`, job middleware | serialized tenant and DB context | serialized tenant and shared context | REFACTOR | context | 6 | High; worker leakage |
| `TenantCacheKey.php`, `TenantPrivatePath.php` | tenant keys/paths | same contract using current ID | KEEP | context | 6 | Medium; unit/security |
| `TenantDatabaseName.php`, `CreateTenantDatabase.php` | name, information-schema and DB creation | no MVP responsibility | DEPRECATE / REMOVE LATER | registration/provisioner | 8, 11 | High; reference search |
| `TenantFoundationSeeder.php` | tenant-connection BDT/USD/audit | shared-schema initializer inside onboarding | REFACTOR | models | 7 | High; idempotency |
| `TenantProvisioner.php` | DB provisioning/migration/foundation | `TenantOnboardingService` transaction/orchestration | REPLACE | registration/audits | 7 | Very High; rollback/idempotency |
| `TenantMigrateCommand.php`, `TenantSeedFoundationCommand.php` | tenant DB operations | remove after cutover | DEPRECATE / REMOVE LATER | runbooks | 8, 11 | High; command absence/reference audit |
| provision/retry commands | invoke provisioner | onboarding repair command only if needed | REFACTOR | onboarding | 9 | Medium; authorization/retry |
| `RegisterTenantAccount.php`, RegisterTenant UI, provisioning view/controller | central rows then synchronous DB provision | transaction + after-commit onboarding/status | REFACTOR | onboarding | 7, 9 | High; registration/idempotency |
| central tenant/domain/membership/invite models | platform registry/access | same; remove database-name field in corrective migration | REFACTOR | migrations | 4–5 | High; schema/data validation |
| provisioning attempt/audit/status services | retries/redacted audit/lifecycle | onboarding checkpoints/audit | REFACTOR | onboarding | 7 | Medium; failure state |
| tenant models/company policy | tenant-connection data/policy | explicit tenant/company chain | REPLACE | scopes/policies | 3–5 | Very High; IDOR and policy |
| tenant migrations | per-database foundation/marker | historical reference until shared migrations validated | DEPRECATE / REMOVE LATER | migration case | 4, 11 | Very High; backup/rehearsal |
| central/default migrations | central schema with `Schema::connection` | one migration stream/primary connection | REFACTOR | DB plan | 4–5 | Very High; status/data checks |
| tests (`CentralConnection`, auth, tenancy units) | central and DB-per-tenant assumptions | shared-schema contracts/isolation matrix | REFACTOR | all above | 3–10 | High; two-tenant regression |
| tenancy/provisioning/setup docs | database-per-tenant operating guides | archived/deprecation and shared-schema runbooks | REFACTOR | ADR | 2, 12 | Low; documentation review |
