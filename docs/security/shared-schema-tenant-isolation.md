# Shared-schema tenant isolation security model

## Threats and mandatory controls
| Threat | Mandatory control |
|---|---|
| IDOR, missing filter, route binding, soft deletes | required trusted context; `BelongsToTenant` scope; scoped binding returns 404; policies and service assertion |
| request/mass-assignment tenant spoofing | guard `tenant_id`; assign only server-side on creating; reject mismatches |
| context spoofing | exact verified domain or authorized server-side workspace selection; never header/query/body tenant ID |
| Livewire hydration/signed URL/API | reload scoped record and authorize every action; signatures authenticate integrity, not ownership; shared API policy path |
| export/search/dashboard/report leakage | query object begins with tenant/company scope; test aggregate and export queries with two tenants |
| queues/scheduler | serialized tenant ID; reload/context/clear in `finally`; scheduler iterates explicit tenants; no ambient worker state |
| cache/files/audit logs | `tenant:{id}:` cache names; private `tenants/{id}` paths plus download policy; audit reads scoped/redacted |
| joins/bulk writes/deletes | every join includes tenant relation; query builders begin tenant predicate; prohibit unscoped `update/delete`; transaction/service asserts chain |
| admin bypass | `WithoutTenantScope` is platform-only, named, reviewed, audited, policy-protected, and unavailable to normal tenant paths |

## Defense-in-depth design
`BelongsToTenant` contract exposes `tenantId(): int|string`; trait adds a `TenantScope`, assigns the trusted ID on `creating`, guards it, exposes `scopeForTenant`, and throws `TenantMismatchException` when an explicit owner disagrees. Global scope is a guardrail, not the boundary: policies, actions and database constraints remain compulsory. `WithoutTenantScope` must be an explicit, narrowly scoped platform query method requiring platform privilege and audit reason—not `withoutGlobalScopes()` sprinkled in application code.

Route middleware resolves context before binding. Bind company with current `tenant_id`; bind branch with tenant and selected company. Never use `find($id)` for a tenant resource. Scope validation and unique rules, factories (`tenantFactory`, `companyFactory`, `branchFactory`), and helpers (`createTenantContext`, `actingAsTenantOwner`, `actingAsTenantMember`, `assertTenantIsolation`, `assertModelBelongsToTenant`) standardize enforcement.

## Review and observability
Review every model, relation, join, bulk statement, cache key, job, export, file endpoint and Livewire public method. Static convention: raw `DB` for tenant data requires a query object and explicit tenant predicate; no UI-provided tenant ownership IDs. Log request ID, actor, action and tenant ID where authorized, but never secrets, tokens, full PII, or cross-tenant existence details. Production alerts classify suspected leakage as a security incident: preserve logs, revoke affected access, scope impact, communicate, remediate and add regression coverage.
