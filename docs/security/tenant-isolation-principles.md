# Tenant Isolation Principles

These rules are non-negotiable for all future implementation phases.

1. Tenant identity is never trusted from form input.
2. Tenant identity comes from a verified domain or authorized switch.
3. Unknown domains fail closed.
4. There is no fallback tenant.
5. Platform routes never initialize tenant context.
6. Tenant routes require active tenant context.
7. Tenant access requires an active membership.
8. Company access requires explicit authorization.
9. Central models never use tenant connections.
10. Tenant models never use central connections.
11. Queue jobs initialize and clear tenant context.
12. Cache keys include tenant identity.
13. Tenant files use isolated paths.
14. Suspended tenants cannot access operational routes.
15. Backend policies enforce authorization.
16. Hidden menu items are not access control.
17. Tenant database names never use unsafe user input.
18. Invitation tokens are hashed.
19. Audit logs never store secrets.
20. Cross-tenant lookup must be impossible by default.

## Enforcement expectations
Every controller, Livewire component, policy, queued job, command, and service introduced after Phase 1.1 must be reviewed against these rules. Violations are release blockers.
