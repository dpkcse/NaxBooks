# Target SaaS architecture

The target product uses a central platform database and a separate database per tenant with subdomain-based tenant resolution. Tenants may contain multiple companies and branches. This phase prepares namespaces only and intentionally does not select a tenancy package or implement tenant resolution.
