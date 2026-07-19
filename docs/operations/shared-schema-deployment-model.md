# Shared-schema deployment and operations model

## MVP topology and simplification
One Laravel deployment serves staging and production separately; each uses one MySQL primary, Redis (approved cache/queue), queue workers, scheduler, private object storage, centralized logs/metrics/alerts, TLS wildcard/subdomains and CI/CD. Shared schema removes per-tenant DB creation/credentials, schema fleet migrations, tenant backup catalogs, connection-switch debugging, ownership-marker checks and provisioning DB privileges.

## Deployment and migration checklist
1. Validate build/tests/static analysis and review migration/query plans. 2. Confirm encrypted backup and restore point, free capacity, migration duration/lock risk and tenant-impact notice. 3. Deploy immutable release and secrets, run only reviewed forward/expand migration once, clear/rebuild config cache, restart workers after deploy, and check `/up`, queue lag, error rate and scoped smoke tests. 4. Record release/migration IDs and observe.

Use expand/contract migrations: additive nullable columns/indexes first, backfill in bounded resumable jobs, deploy compatible code, validate, then contract in a later release. Never roll back by restoring blindly over active writes. Application rollback is previous compatible artifact; schema rollback requires separately rehearsed forward corrective migration or point-in-time restore.

## Backup, restore, secrets and incidents
Back up MySQL encrypted with retention and point-in-time recovery appropriate to owner-approved RPO/RTO; test full and tenant-scoped logical recovery in staging. Object storage backup/versioning follows the same retention plan. Store DB/Redis/storage credentials in managed secrets, least-privilege service accounts, rotation runbook; production app has no `CREATE DATABASE` privilege. Workers use a graceful restart after deploy and are monitored for failed jobs, lag and context errors. Incident response: declare, preserve request/audit logs, identify affected tenant IDs, contain access, restore/replay only after approval, communicate impact, and add regression tests. Health checks cover app, DB connectivity, Redis, queue/scheduler heartbeat, storage reachability and backup freshness.
