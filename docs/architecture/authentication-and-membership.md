# Authentication and Membership Architecture

Central authentication establishes user identity in the central database only. Tenant access requires selecting an active tenant membership after authentication. Platform administration uses separate central user flags and isolated routes; platform roles are not tenant roles.

Central records own users, tenants, domains, memberships, invitations, provisioning attempts, and platform audit logs. No tenant database switching or cross-database joins are introduced in Phase 1.2.
