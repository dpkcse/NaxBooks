# Local provisioning validation

Use a disposable MySQL/MariaDB server only. Set `TENANT_PROVISIONING_MODE=sync` locally, run central migrations, register a new workspace, and inspect the generated tenant schema for `tenant_system_metadata`, currencies, company settings, company, branch, and access records. Production should use queue mode and a worker.
