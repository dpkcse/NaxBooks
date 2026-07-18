# Central Authentication Security

- Disabled users are rejected by Fortify authentication and active-user middleware.
- Login throttling uses Fortify's login limiter.
- Logout invalidates the session and regenerates the CSRF token.
- Password reset tokens remain in Laravel's hashed reset-token table; raw reset tokens are not logged.
- Tenant invitation tokens must be stored as hashes only.
- Authentication does not grant tenant access.
- Tenant lifecycle status is changed through `TenantStatusTransitionService`, not form mass assignment.
