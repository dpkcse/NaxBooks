# Authentication Foundation Decision

## Decision
Select **Laravel Fortify with custom Blade/Livewire UI** for Phase 1.2. Do not install or scaffold during Phase 1.1.

## Rationale
Fortify provides backend authentication actions for login, logout, registration, email verification, password reset, login throttling, and session regeneration while allowing NAXAS to build SaaS-specific Blade/Livewire screens. Breeze is fast but couples starter UI decisions to auth. Fully custom auth increases security risk and test burden.

## Required extensions
- Disabled-user login denial.
- Platform-admin separation from tenant membership.
- Tenant membership checks after tenant context resolution.
- Verified email enforcement for operational routes.
- Central sessions with explicit tenant context controls.
- Tests for throttling, regeneration, disabled users, verification, and membership gates.
