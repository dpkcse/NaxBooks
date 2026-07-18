# Central Authentication Security

- Fortify authentication and web middleware reject disabled central users without revealing whether the user exists.
- Login throttling is keyed by normalized email and IP address.
- Fortify owns logout and invalidates the session and CSRF token.
- Password-reset and invitation raw tokens are never logged; invitation tokens are persisted only as hashes.
- `PlatformAuditService` recursively redacts keys containing password, token, secret, cookie, session, APP_KEY, authorization, or database credential/URL fragments.
- Audit records are append-only: normal Eloquent update/delete events are refused.
- Tenant lifecycle status is not fillable and may only transition through `TenantStatusTransitionService`.
- Authentication does not establish tenant access or a tenant database connection in Phase 1.2.
