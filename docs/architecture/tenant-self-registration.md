# Tenant self-registration

```mermaid
sequenceDiagram
 Browser->>Livewire: /register-business
 Livewire->>RegisterTenantAccount: validated DTO
 RegisterTenantAccount->>Central DB: user, tenant, domain, membership (transaction)
 RegisterTenantAccount->>TenantProvisioner: after commit
 TenantProvisioner->>Tenant DB: create, migrate, mark, seed
 Browser->>Status: authorized provisioning page
```

The customer is redirected to the tenant login rather than silently sharing a central session across subdomains. Queue mode is reserved for deployment with a configured worker; `sync` is suitable only for local setup.
