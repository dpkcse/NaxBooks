# ADR: Shared-schema tenancy for MVP
- **Status:** Accepted
- **Owner approval:** 2026-07-19
- **Approval record:** The owner approved one Laravel modular monolith, one primary MySQL database, and one shared schema for the MVP. Database-per-tenant feature expansion is frozen; the existing legacy runtime remains temporary. Any runtime migration occurs only through the approved transition plan. A controlled dedicated-database extension for selected enterprise tenants remains deferred and is not implemented now.
- **Decision:** Use one Laravel modular monolith, one primary MySQL database, and one shared schema. Tenant-owned rows carry `tenant_id`; company and branch rows also carry their applicable ownership IDs. No MVP runtime database switching, database creation, or tenant migration fleet.

## Decision matrix
Ratings express operational/development burden except security/compliance/performance/extensibility, where higher means stronger potential when properly implemented.
| Criterion | A: DB per tenant | B: shared schema | C: hybrid now |
|---|---|---|---|
| Development / maintenance / local development | High / Very High / High | Medium / Medium / Low | Very High / Very High / Very High |
| Deployment, migrations, CI/CD, onboarding | Very High / Very High / High / Very High | Low / Medium / Low / Low | Very High / Very High / Very High / Very High |
| Backup/restore, DR, incident response | High / Very High / Very High | Medium / Medium / Medium | Very High / Very High / Very High |
| Reporting, Livewire, queues, cache/files | High / Medium / High | Low / Low / Medium | Very High / High / Very High |
| Automated testing / observability / cost | High / High / High | Medium / Medium / Low | Very High / Very High / Very High |
| Isolation/security/compliance potential | High | Medium-High (defense in depth) | High |
| Performance / long-term extensibility | Medium / High | High / High | High / Very High |
| Small-team suitability / time to market | Low / Low | High / High | Low / Low |

## Consequences
**Keep:** central identity, exact domain resolution, memberships, lifecycle, audit redaction, tenant-aware cache/files/jobs, foundation concepts. **Refactor:** context, onboarding, models, policies, queue middleware, tests. **Deprecate then remove later:** provisioning/tenant connections, DB creator/name/marker, migration commands and tenant directory. **Defer:** accounting, RBAC, subscriptions and enterprise implementation. **Future enterprise only:** dedicated database extraction after proven contractual/storage seams.

### Team evaluation
- **Senior developer:** one schema and migrations makes review and domain transactions tractable; explicit scopes increase discipline.
- **Frontend developer:** one route/data contract; UI never supplies trusted scope IDs.
- **DevOps:** one deployment, backup plan, migration runbook and worker topology replaces fleet administration.
- **Test engineer:** can build deterministic two-tenant leakage tests in one test database; must treat isolation as a release gate.

## Alternatives and safeguards
A remains valid only where contractual physical isolation outweighs team cost. C is a future option, not an MVP: implementing both strategies now doubles paths without customer evidence. B requires tenant-aware constraints, scoped queries/joins, policy and service checks, route binding, jobs/cache/files, and automated leakage tests. Reconsider if compliance mandates dedicated physical storage or verified scale/restore requirements cannot be met.
