# Proposed SRS tenancy amendment

## Replace MVP tenancy requirements
**MVP Tenancy Model:** The platform shall use a shared database and shared schema with mandatory `tenant_id` isolation, tenant-aware authorization, scoped queries, scoped unique constraints, tenant-aware cache/job/file handling, and automated cross-tenant leakage tests.

**Future Enterprise Extension:** The architecture may support selected dedicated-database tenants through a controlled storage strategy without changing business-domain contracts.

## Requirement impact
| Requirement | Amendment |
|---|---|
| Isolation | Replace physical-per-tenant assertion with defense-in-depth row isolation and 404 binding behavior |
| Provisioning | Create tenant/domain/membership/foundation rows; no `CREATE DATABASE` or tenant migration |
| Database management/deployment | one primary schema and migration pipeline; release rollback is expand/contract compatible |
| Backup/restore | one encrypted primary backup process plus tested tenant-scoped logical recovery procedure |
| Cache/queue/files | shared infrastructure with tenant-prefixed key, serialized tenant ID/context, and private tenant path/authorization |
| Domains/registration | exact verified domain resolution remains; registration onboards rather than provisions a DB |
| Acceptance | two-tenant leakage suite, scoped constraints, policy/binding/job/file tests are mandatory |
| Enterprise isolation | deferred controlled dedicated-store option, not MVP behavior |
