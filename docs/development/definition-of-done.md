# Definition of Done

A future module is complete only when its migration has been reviewed and rollback impact documented; tenant/company/branch/period ownership is enforced; policies and scoped validation/unique constraints exist; UI contains no business logic; required audit events exist; normal, authorization and leakage tests pass; loading, empty and error states are responsive and accessibility-checked; Pint, PHPStan and frontend build pass; docs/runbooks are updated; monitoring/operational impact is known; and no critical blocker remains. The reviewer confirms no unscoped raw query, bulk write, cache key, job, file path, export, route binding, signed URL or Livewire action was introduced.

## Tenancy transition guardrail
Until the shared-schema transition is complete, code review rejects new tenant database switching, tenant connection calls, database creation, tenant migration commands, and tenant migration files. A transition increment must state migrations/data/connections/provisioning non-changes, provide rollback evidence, and preserve legacy behavior until its approved removal prerequisite is met.
