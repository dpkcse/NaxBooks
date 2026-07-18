# ADR-007: Authentication Foundation


Status: Accepted for Phase 1.1

## Context
NAXAS AI SME Accounting & Real Estate Management SaaS needs strict platform-to-tenant isolation using a central platform database and separate tenant databases. Phase 1.1 is documentation-only and does not install packages or implement runtime features.

## Decision
Use Laravel Fortify with custom Blade/Livewire UI. Use central records for identity, tenancy, domains, membership, invitations, provisioning, platform audit, and future plans/subscriptions. Use tenant databases for companies, branches, fiscal years, periods, tenant permissions, company access, tenant audit, and future business transactions.

## Alternatives considered
- Single shared database with tenant_id scoping.
- Fully custom tenancy across all concerns.
- Mixed central and tenant ownership without explicit boundaries.

## Reasons for rejection
Shared tables increase blast radius and make cross-tenant query mistakes more likely. Fully custom tenancy increases implementation burden for queues, cache, filesystem, and migrations. Ambiguous ownership creates authorization and data residency risk.

## Security consequences
Tenant context must be initialized only from verified domains or authorized switches and cleared after requests/jobs. Unknown tenants fail closed. Platform and tenant routes remain isolated.

## Database consequences
Central models use the central connection only. Tenant models use the tenant connection only. Cross-database foreign keys are not assumed; UUID references and application-level checks will be used where boundaries cross.

## Testing consequences
Every future phase must include tenant isolation tests, unknown-domain tests, suspended-tenant tests, queue context tests, and authorization policy tests.

## Operational consequences
Provisioning requires database creation privileges, migration orchestration, retries, locks, sanitized failures, and observable audit events.

## Future extension considerations
The design leaves room for billing, custom domains, per-tenant backups, data export, regional databases, and real estate/accounting modules without weakening isolation.
