# Phase 1.2 Test Matrix

| Area | Required coverage | Execution target |
| --- | --- | --- |
| Central connection | Connection exists; every central model resolves to `central`; platform routes do not initialize a tenant connection. | Laravel feature tests |
| Schema | Central migrations, no duplicate users table, valid invitation expiry, FK restrictions, unique constraints, enum defaults. | Disposable MariaDB 10.4 / MySQL 8 integration database |
| Authentication | Active/disabled login behavior, generic failures, regeneration/logout invalidation, verification, reset, confirmation, throttling. | Laravel feature tests |
| Lifecycle | Valid/invalid transitions, archived terminal behavior, timestamp updates, status mass-assignment protection. | Unit/feature tests |
| Audit | Recursive redaction, request ID, old/new values, tenant ID, immutable records. | Unit/feature tests |
| Isolation/UI | Platform administrator isolation; membership is not platform privilege; auth/dashboard pages render; selector lists active memberships only. | Laravel feature tests |

SQLite is useful for fast non-schema tests but is not evidence of MariaDB 10.4 or MySQL 8 migration compatibility.
