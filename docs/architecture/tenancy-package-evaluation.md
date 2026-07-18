# Tenancy Package Evaluation

## Decision
Recommend **stancl/tenancy** for Phase 1.3 if Composer confirms the stable release resolves with Laravel 12 and PHP platform 8.2.12 in this repository. Do not install during Phase 1.1.

## Comparison
| Criterion | stancl/tenancy | spatie/laravel-multitenancy | Custom |
|---|---|---|---|
| Laravel 12 compatibility | Current Packagist metadata indicates active Laravel support; must verify by `composer require --dry-run` in Phase 1.3. | Actively maintained and supports modern Laravel; verify by dry-run. | Fully controlled but must track Laravel internals. |
| Database per tenant | First-class automatic mode. | Supported via tasks. | Possible but expensive. |
| Subdomain identification | Built-in hostname/domain identification. | Domain finder available/configurable. | Must build. |
| Central/tenant migrations | Built-in conventions. | Requires more manual orchestration. | Must build. |
| Queue tenancy | Built-in/bootstrapped patterns. | Task-based/current tenant handling. | Must build and test. |
| Cache/filesystem tenancy | Built-in bootstrappers. | Task/prefix approach. | Must build. |
| Event lifecycle | Rich tenancy events. | Simpler task lifecycle. | Must design. |
| Testing support | Established community patterns. | Established package patterns. | Custom fixtures needed. |
| Upgrade risk | Medium; deep integration. | Lower integration depth but more custom code. | Highest maintenance burden. |
| Complexity | Medium. | Medium-high for strict isolation. | High. |
| Conflicts | Must test with Livewire 4, queues, cache, filesystem. | Fewer magic conflicts but more gaps. | Internal conflicts likely. |

## Rejected alternatives
Spatie remains a strong fallback if stancl cannot resolve cleanly. Custom tenancy is rejected for Phase 1 because the project needs proven database-per-tenant, domain, queue, cache, and filesystem patterns quickly.
