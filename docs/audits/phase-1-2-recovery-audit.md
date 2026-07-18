# Phase 1.2 Recovery Audit

**Audit date:** 2026-07-18. **Checked-out Git branch:** `work` (reported exactly by `git branch --show-current`; no assumption is made about any external sandbox branch).

## Baseline and dependency finding

`composer.json` requires `laravel/fortify ^1.30`, but the committed `composer.lock` contains no Fortify package. One `composer update laravel/fortify --with-all-dependencies --no-interaction` attempt was made; Packagist returned HTTP 403, so the lockfile was deliberately **not** hand-edited and Composer was not retried. Runtime Fortify/API checks remain blocked until a network-enabled local `composer update` updates the lockfile. The unsupported `Features::confirmPasswords()` call was removed: password confirmation remains Fortify route/view functionality and is not a feature toggle.

`vendor/` is absent in this environment. No database migrations had been run from this checkout, and no destructive database command was used. The original Phase 1.2 migration is therefore corrected in place rather than followed by a corrective migration. Deployments where the old migration may already have run must use a separately reviewed corrective migration instead of rewriting migration history.

## Recovery findings and decisions

| Area | Finding | Recovery decision |
| --- | --- | --- |
| Central configuration | `central` fell back to the default DB variables without documentation; database-backed sessions/cache/queues could use the default connection. | Retain explicit local fallback for a deliberately aligned local database, document it, and pin session/cache/queue database connections to `central`. |
| Schema | The tenancy migration lacked owner/lifecycle/domain/membership/invitation/provisioning/audit fields required by the ADRs. | Align it to the approved central schema with restricted parent deletes, unique tenant/member and tenant/attempt constraints, and query indexes. |
| MariaDB 10.4 | Non-null `tenant_invitations.expires_at` was a `timestamp`, which generated an invalid default on MariaDB 10.4. | Use a required `dateTime('expires_at')`; all business lifecycle datetime fields use nullable `dateTime`. |
| Lifecycle enum | `pending_provisioning` and the reduced transition graph contradicted the lifecycle ADR. | Replace with the nine approved values and enforce the documented transitions. |
| Models/services | Several models used obsolete field names (`role`, `attempt`, `message`, `metadata`, `auditable_*`). Audit logging lacked old/new values and robust secret redaction. | Rename to approved fields, add casts/relations, make audit records immutable, and redact sensitive key fragments recursively. |
| Authentication/routes | A custom `/logout` duplicated Fortify's route. | Remove the duplicate; Fortify owns logout/session invalidation. |

## Scope and security conclusions

This recovery adds neither a tenancy package nor tenant connection switching, provisioning execution, business modules, subscriptions, or billing. Authentication remains central identity only; tenant selection is restricted to active central memberships. Platform routes use the existing verified-authenticated platform-admin middleware and tenant membership does not confer platform privilege.

## Runtime status

Repository/source checks were performed. Composer, Artisan, Fortify route, migration, test, Pint, and PHPStan runtime checks are deferred because dependencies cannot be installed while Packagist is blocked. MariaDB/MySQL behavior must be validated against a disposable local MariaDB 10.4 database before release; SQLite is not accepted as proof of this compatibility.
