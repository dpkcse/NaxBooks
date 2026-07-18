# Domain Resolution Architecture

Supported local domains: `naxbooks.test` (central), `admin.naxbooks.test` (admin), and `demo.naxbooks.test` (tenant). Future custom domains are normalized and verified before activation.

Reserved subdomains: `admin`, `app`, `api`, `www`, `support`, `mail`, `billing`, `status`.

## Decision
Platform routes are served only on central/admin domains and never initialize tenant context. Tenant routes are served on verified tenant domains and require initialized tenant context before controllers or Livewire components run.

## Resolution rules
1. Lowercase and trim host, remove trailing dot, IDNA-normalize, and strip port.
2. Reject reserved tenant subdomains during domain creation.
3. Exact central/admin domains route to platform middleware only.
4. Verified tenant/custom domains resolve through central `domains.normalized_domain`.
5. Unknown domains return 404/tenant-not-found without fallback.
6. Inactive domains fail closed.
7. Suspended tenants may access only allowed billing/support/read-only routes.

## Middleware order
Trust proxies -> host normalization -> platform-domain guard or tenant-domain resolver -> tenant status guard -> membership guard -> company authorization -> controller/Livewire.

## Livewire context
Livewire update routes must run through the same tenant resolver and membership middleware as initial tenant pages. Component payload tenant ids are ignored.

## Safe switching
Tenant switching is allowed only from central authenticated context, only to tenants where the user has active membership, and redirects to that tenant's verified primary domain.
