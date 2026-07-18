# Authentication and Membership Architecture

Fortify authenticates `User` records on the `central` connection only. Active central identity does not grant tenant access, initialize a tenant connection, or execute provisioning. Tenant selection is a UI placeholder that queries only active central memberships.

Fortify enables registration, password reset, email verification, profile updates, and password updates. Password confirmation is configured by Fortify's route/view support; it is not included in the `Features` feature-toggle list. The login limiter permits five attempts per email/IP key per minute. Fortify owns the POST logout route and invalidates the session/rotates the CSRF token.

Platform administration requires an authenticated, verified user with `is_platform_admin`; a tenant membership alone is insufficient.
