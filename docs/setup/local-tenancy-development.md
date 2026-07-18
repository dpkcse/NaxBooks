# Local tenancy development
Add these hosts entries:
```
127.0.0.1 naxbooks.test
127.0.0.1 admin.naxbooks.test
127.0.0.1 demo.naxbooks.test
```
Set `CENTRAL_DOMAINS=naxbooks.test`, `ADMIN_DOMAINS=admin.naxbooks.test`, central database values, and `TENANT_DB_CONNECTION=mysql` plus `TENANT_DB_HOST`, `TENANT_DB_PORT`, `TENANT_DB_USERNAME`, `TENANT_DB_PASSWORD`, `TENANT_DB_SOCKET`, `TENANT_DB_CHARSET`, and `TENANT_DB_COLLATION`. Create the verified `demo.naxbooks.test` central domain and its central tenant record before accessing it.
