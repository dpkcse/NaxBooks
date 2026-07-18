# Central Database Ownership

The central database owns identity, tenancy, membership, domains, provisioning, platform audit, and future commercial records. Central tables never store tenant business transactions.

| Table | Purpose | Ownership | Main fields | Unique constraints | Indexes | Foreign keys | Lifecycle rules | Deletion policy |
|---|---|---|---|---|---|---|---|---|
| users | Central login identities. | Platform. | id, name, email, password, email_verified_at, disabled_at, last_login_at. | email. | disabled_at, email_verified_at. | none initially. | Created by registration/invitation/admin. | Soft-delete or disable; preserve audit links. |
| tenants | Workspace records. | Platform. | id/uuid, name, slug, status, database_name, owner_user_id, provisioned_at. | slug, database_name. | status, owner_user_id. | owner_user_id -> users. | Status transitions only through lifecycle service. | Archive; no hard delete while audit/subscription exists. |
| domains | Tenant and future custom domains. | Platform. | id, tenant_id, domain, normalized_domain, type, is_primary, verified_at, active. | normalized_domain. | tenant_id, active, type. | tenant_id -> tenants. | Unknown domains fail closed. | Delete only after tenant archive or replacement. |
| tenant_memberships | User access to tenants. | Platform. | id, tenant_id, user_id, status, role_hint, joined_at. | tenant_id + user_id. | user_id, tenant_id, status. | tenant_id -> tenants; user_id -> users. | Active membership required for tenant routes. | Soft delete/revoke for audit. |
| tenant_invitations | Pending membership invitations. | Platform. | id, tenant_id, email, token_hash, invited_by_user_id, expires_at, accepted_at. | tenant_id + email + active token. | token_hash, expires_at. | tenant_id -> tenants; invited_by_user_id -> users. | Tokens are hashed; expired invitations unusable. | Prune expired after retention. |
| provisioning_attempts | Idempotent provisioning progress. | Platform. | id, tenant_id, idempotency_key, status, completed_steps, error_code. | idempotency_key. | tenant_id, status. | tenant_id -> tenants. | One active attempt per tenant via lock. | Retain for operations/audit. |
| platform_audit_logs | Security and operational audit. | Platform. | id, actor_user_id, tenant_id nullable, event, ip_hash, metadata, created_at. | none. | actor_user_id, tenant_id, event, created_at. | actor_user_id -> users nullable; tenant_id -> tenants nullable. | Never store secrets. | Immutable append-only with retention policy. |
