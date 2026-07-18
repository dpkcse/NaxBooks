# Role and Permission Package Evaluation

## Decision
Use a **hybrid architecture**: central platform roles remain in central tables/guards, while tenant roles and permissions live in each tenant database using separate tables, tenant connection, and tenant-scoped permission cache keys. Evaluate `spatie/laravel-permission` for tenant roles in Phase 1.5 after tenant connections exist.

## Comparison
| Criterion | spatie/laravel-permission | Custom roles |
|---|---|---|
| Laravel 12 compatibility | Current package metadata advertises Laravel 12 support; verify by dry-run before install. | Compatible if built correctly. |
| Tenant database compatibility | Works if models/table names/cache are configured per tenant connection. | Full control. |
| Permission cache isolation | Must customize prefix/registrar reset per tenant. | Built in by design if implemented. |
| Central roles | Use separate central tables or simple enum/policies. | Full control. |
| Tenant roles | Mature package semantics. | More code and tests. |
| Company access | Needs custom company assignment table/policies. | Full control but more work. |
| Testability | Good with package helpers plus isolation tests. | More unit burden. |
| Upgrade risk | Medium. | Internal maintenance risk. |

## Non-negotiable boundary
Platform roles must never be queried from tenant databases or cached under tenant permission keys. Tenant roles must never grant platform-admin privileges.
