# Phase 1.2 Test Matrix

| Area | Coverage |
| --- | --- |
| Central connection | All central models assert `central` connection. |
| Authentication | Disabled users are rejected; logout invalidates sessions. |
| Authorization | Platform routes require verified platform administrators. |
| Lifecycle | Allowed tenant status transitions are explicit. |
| Mass assignment | Tenant lifecycle status is not fillable. |
| Audit | Sensitive audit metadata is recursively redacted. |

Full runtime validation requires local Composer dependencies.
