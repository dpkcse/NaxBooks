# Central Database Ownership

The `central` connection owns platform identity and tenancy metadata only. It never contains tenant business transactions. Phase 1.2 does not register, select, or switch a tenant database connection.

| Table | Key fields and integrity |
| --- | --- |
| `users` | Central identity; unique email; `status` (`active`/`disabled`) and platform-admin flag. |
| `tenants` | Unique slug/database name; restricted `owner_user_id`; lifecycle status, lifecycle datetimes, and JSON settings. |
| `domains` | Restricted tenant FK, globally unique domain, type/status, primary/verified booleans and verification datetime. |
| `tenant_memberships` | Restricted tenant/user FKs, `role_key`, status/datetimes, and unique tenant/user pair. |
| `tenant_invitations` | Hashed token, intended role key, inviter, required expiry, acceptance/revocation datetimes; invitation tokens are never stored raw. |
| `provisioning_attempts` | Diagnostics only: retry number, step data, sanitized error data, request/initiator and lifecycle datetimes; unique tenant/attempt number. It does **not** execute provisioning. |
| `platform_audit_logs` | Immutable append-only audit entries with optional actor/tenant, entity identifiers, old/new JSON, reason, request metadata, and no secrets. |

All platform migrations explicitly use `Schema::connection('central')`. In disposable local MariaDB development, default `DB_*` and `CENTRAL_DB_*` may intentionally name the same database. Production must configure `CENTRAL_DB_CONNECTION`, `CENTRAL_DB_HOST`, `CENTRAL_DB_PORT`, `CENTRAL_DB_DATABASE`, `CENTRAL_DB_USERNAME`, `CENTRAL_DB_PASSWORD`, and (where applicable) `CENTRAL_DB_SOCKET` explicitly. Database sessions, cache, and queues use `central` by default in Phase 1.2.

Business lifecycle fields use `DATETIME`, including invitation expiry, for MariaDB 10.4 compatibility; the target production database is MySQL 8+.
