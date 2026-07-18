# Phase 1.2 Completion Report

Phase 1.2 implements the central authentication and tenancy-schema foundation only. Tenant switching, domain initialization, provisioning execution, subscriptions, billing, permissions packages, and business modules remain out of scope.

## Recovery update (2026-07-18)

The central schema now matches the approved lifecycle and ownership documentation; business lifecycle datetimes use MariaDB 10.4-safe `DATETIME`, including required invitation expiry. The tenant lifecycle enum is `pending`, `provisioning`, `provisioning_failed`, `trialing`, `active`, `grace_period`, `suspended`, `cancelled`, and `archived`. Fortify's unsupported `Features::confirmPasswords()` call was removed while its password-confirmation view/route support remains enabled. A duplicate project logout route was removed in favor of Fortify.

The repository currently requires `laravel/fortify ^1.30`, but the committed lockfile does not include Fortify. A single recovery-time Composer update was blocked by Packagist HTTP 403; the lockfile was not manually edited. Complete Composer resolution and the MariaDB/MySQL runtime matrix on a network-enabled local environment before release.
