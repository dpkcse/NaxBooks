# Tenant database connection
The `central` connection is explicit on every central model. `tenant` is a null-database template whose credentials come only from `TENANT_DB_*`; its database is assigned at runtime from `tenants.database_name`, never host, slug, or request data. No tenant tables, cross-database joins, or cross-database foreign keys are introduced in Phase 1.3.
