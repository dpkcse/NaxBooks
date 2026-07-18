# Tenant Lifecycle

Supported statuses: pending, provisioning, trialing, active, grace_period, suspended, cancelled, archived, provisioning_failed.

## Allowed transitions
- pending -> provisioning, cancelled
- provisioning -> trialing, active, provisioning_failed
- provisioning_failed -> provisioning, cancelled, archived
- trialing -> active, grace_period, suspended, cancelled
- active -> grace_period, suspended, cancelled
- grace_period -> active, suspended, cancelled
- suspended -> active, cancelled, archived
- cancelled -> archived
- archived has no normal outbound transition

Arbitrary status changes are forbidden; all transitions must go through a lifecycle service that validates actor, reason, and audit logging.

## Access rules
- pending/provisioning/provisioning_failed: no operational tenant access.
- trialing/active: normal access if membership and company authorization pass.
- grace_period: operational access may continue with billing warnings.
- suspended: no operational routes; only billing/support/export routes if allowed.
- cancelled: no operational routes; limited owner/admin access for export/reactivation policy.
- archived: no user access; operator-only retention workflows.
