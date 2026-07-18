# Provisioning security
Database names derive only from immutable central tenant IDs and are validated against `[a-z0-9_]{1,64}` before backtick quoting. Request slugs, domains, and company names never participate. `PROVISIONING_DB_*` is separate from `TENANT_DB_*`; runtime credentials need no `CREATE DATABASE` grant. Existing databases are never dropped by this phase.

Failures retain a bounded, sanitized message and generic code, not credentials or stack traces. A cache lock serializes attempts, and the tenant context is cleared in `finally` on every path.
