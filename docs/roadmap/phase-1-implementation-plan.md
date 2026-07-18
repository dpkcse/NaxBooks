# Phase 1 Implementation Plan

## Phase 1.2 Authentication and central database
Scope: Fortify auth foundation, central users hardening, tenants/domains/memberships/invitations/provisioning/audit migrations. Models: central User, Tenant, Domain, TenantMembership, TenantInvitation, ProvisioningAttempt, PlatformAuditLog. Services: auth actions, disabled-user guard, audit writer. UI: Blade/Livewire auth screens. Tests: auth, verification, reset, throttling, disabled users. Security: session regeneration, hashed invitation tokens. Acceptance: central auth passes. Dependencies: Phase 1.1. Excluded: tenant DB runtime.

## Phase 1.3 Tenant resolution and database-per-tenant
Scope: install selected tenancy package, central/tenant connection config, domain resolver, tenant middleware. Migrations: tenant migration path skeleton only. Models: tenant base model. Services: tenant context. UI: basic tenant landing placeholder. Tests: unknown/inactive/suspended domains, isolation. Security: no fallback tenant. Excluded: provisioning UI/business modules.

## Phase 1.4 Provisioning, company, and branch
Scope: idempotent tenant provisioner and default company/branch creation. Migrations: companies, branches, currencies, company_settings, company_user_access. Services: provisioning workflow, database creator. UI: minimal owner onboarding. Tests: retries, locks, default records. Security: safe DB names. Excluded: accounting/real estate transactions.

## Phase 1.5 Fiscal year, periods, roles, and permissions
Scope: fiscal years, periods, tenant roles/permissions, company authorization. Migrations: fiscal_years, accounting_periods, permission tables. Services: period lifecycle, permission cache reset. UI: admin screens for setup only. Tests: company access and permission isolation. Security: platform roles never leak. Excluded: ledgers/transactions.

## Phase 1.6 Invitations, audit, isolation tests, and final QA
Scope: invitations, platform/tenant audit logs, complete isolation QA. Migrations: finalize audit/invitation fields. Services: invite accept/revoke, audit redaction. UI: invitation flows and audit views. Tests: end-to-end tenant isolation, queues/cache/files/sessions. Security: secrets redaction and hashed tokens. Acceptance: full Phase 1 green. Excluded: billing and business modules.
