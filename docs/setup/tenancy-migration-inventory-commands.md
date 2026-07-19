# Read-only tenancy migration inventory commands

> Run against a copied/disposable environment first. Substitute variables locally; do not paste credentials into tickets. These commands contain no DDL/DML.

## Application/configuration
```bash
git status --short
git branch --show-current
git log --oneline -20
php artisan migrate:status
php artisan tinker --execute="dump(config('database.default'), config('database.connections.central.database'), config('database.connections.tenant.database'), config('database.connections.provisioning.database'));"
php artisan tinker --execute="dump(App\\Models\\Central\\Tenant::query()->select('id','slug','database_name','status')->get()->all());"
```

## MySQL/MariaDB inventory
```bash
mysql --defaults-extra-file=/secure/path/central.cnf --batch --skip-column-names -e 'SELECT DATABASE(), @@hostname, @@version;'
mysql --defaults-extra-file=/secure/path/central.cnf --table -e 'SELECT migration,batch FROM migrations ORDER BY batch,migration;'
mysql --defaults-extra-file=/secure/path/central.cnf --table -e "SELECT table_name FROM information_schema.tables WHERE table_schema=DATABASE() ORDER BY table_name;"
mysql --defaults-extra-file=/secure/path/central.cnf --table -e "SELECT table_name,table_rows FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name IN ('users','password_reset_tokens','sessions','cache','jobs','tenants','domains','tenant_memberships','tenant_invitations','provisioning_attempts','platform_audit_logs','companies','branches','currencies','company_settings','company_user_access','tenant_audit_logs','tenant_system_metadata') ORDER BY table_name;"
mysql --defaults-extra-file=/secure/path/central.cnf --table -e 'SELECT id,slug,database_name,status FROM tenants ORDER BY id;'
mysql --defaults-extra-file=/secure/path/provisioning.cnf --table -e "SELECT schema_name FROM information_schema.schemata WHERE schema_name LIKE 'nax_tenant_%' ORDER BY schema_name;"
```

For each returned tenant database, use a read-only tenant credential/config file:
```bash
mysql --defaults-extra-file=/secure/path/tenant.cnf --database=TENANT_DATABASE --table -e "SHOW TABLES; SELECT 'companies' AS table_name,COUNT(*) AS row_count FROM companies UNION ALL SELECT 'branches',COUNT(*) FROM branches UNION ALL SELECT 'currencies',COUNT(*) FROM currencies UNION ALL SELECT 'company_settings',COUNT(*) FROM company_settings UNION ALL SELECT 'company_user_access',COUNT(*) FROM company_user_access UNION ALL SELECT 'tenant_audit_logs',COUNT(*) FROM tenant_audit_logs UNION ALL SELECT 'tenant_system_metadata',COUNT(*) FROM tenant_system_metadata;"
mysql --defaults-extra-file=/secure/path/tenant.cnf --database=TENANT_DATABASE --table -e "SHOW CREATE TABLE companies; SHOW CREATE TABLE branches; SHOW INDEX FROM companies; SHOW INDEX FROM branches;"
```

Record sanitized output, database identity, environment owner, backup/PITR availability, meaningful-data determination, and whether `.env`/deployment variables point at staging or production. Never run `migrate`, DDL, provisioning commands, or INSERT/UPDATE/DELETE during inventory.
