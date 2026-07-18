# Tenant Database Ownership

Each tenant database owns operational business configuration and future transactions for one tenant only. Tenant tables do not store central auth credentials.

| Table | Purpose | Ownership | Main fields | Unique constraints | Indexes | Foreign keys | Lifecycle rules | Deletion policy |
|---|---|---|---|---|---|---|---|---|
| companies | Legal/business entities under a tenant. | Tenant. | id, name, legal_name, registration_no, base_currency_id, active. | registration_no nullable per tenant. | active, base_currency_id. | base_currency_id -> currencies. | Tenant may have multiple companies. | Soft delete when referenced. |
| branches | Company operating locations. | Tenant. | id, company_id, name, code, active. | company_id + code. | company_id, active. | company_id -> companies. | At least one default branch per default company. | Soft delete when referenced. |
| currencies | Tenant currency catalog. | Tenant. | id, code, name, symbol, precision, active. | code. | active. | none. | Seeded during provisioning. | Disable, do not delete when used. |
| fiscal_years | Company fiscal years. | Tenant. | id, company_id, name, starts_on, ends_on, status. | company_id + name; company_id + starts_on + ends_on. | company_id, status. | company_id -> companies. | No overlapping fiscal years per company. | Lock/archive; no hard delete when periods exist. |
| accounting_periods | Fiscal periods. | Tenant. | id, fiscal_year_id, company_id, name, starts_on, ends_on, status. | fiscal_year_id + name. | company_id, fiscal_year_id, status. | fiscal_year_id -> fiscal_years; company_id -> companies. | Period close/open controlled by service. | Lock/archive; no hard delete when transactions exist. |
| company_settings | Per-company configuration. | Tenant. | id, company_id, key, value_json. | company_id + key. | company_id. | company_id -> companies. | Validated by settings service. | Delete with company only if unreferenced. |
| company_user_access | Central users authorized for tenant companies. | Tenant. | id, company_id, central_user_id, access_level, active. | company_id + central_user_id. | central_user_id, company_id, active. | company_id -> companies; central_user_id has no DB FK. | Requires active central membership. | Soft revoke. |
| roles/permissions/model_has_roles/model_has_permissions/role_has_permissions | Tenant authorization roles and permissions. | Tenant. | package-compatible ids, names, guards, model ids. | name + guard. | guard, model id. | Internal tenant FKs only. | Cache isolated per tenant. | Managed by role service; avoid hard delete if assigned. |
| tenant_audit_logs | Tenant-scoped audit events. | Tenant. | id, actor_central_user_id, company_id nullable, event, metadata, created_at. | none. | actor, company_id, event, created_at. | company_id -> companies nullable. | Append-only; no secrets. | Retain per policy/export requirements. |
