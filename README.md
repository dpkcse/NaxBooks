# NAXAS AI SME Accounting & Real Estate Management SaaS

## Product overview
NAXAS Accounting targets a multi-tenant SME accounting and real estate management SaaS with a central platform database, tenant databases, companies, branches, and an immutable double-entry ledger.

## Current phase
Phase 0 engineering foundation only. No accounting, real estate, subscription billing, tenant provisioning, authentication, or authorization module is implemented.

## Target stack
PHP 8.2.12, Laravel 12, MySQL 8+, Redis-ready queues/cache/sessions, Livewire, Blade, Alpine.js, Tailwind CSS, Vite, Pest, Pint, and Larastan/PHPStan.

## Requirements
Install PHP 8.2.12, Composer, Node.js, npm, MySQL 8+, and Redis where Redis-backed stores are enabled.

## Local installation
Run `composer install`, `cp .env.example .env`, `php artisan key:generate`, and `npm install`.

## Environment configuration
Use placeholder domains `naxas.test`, `admin.naxas.test`, and `{tenant}.naxas.test`. Keep all credentials in `.env`; never commit secrets.

## Database setup
Default database is MySQL for the central platform database. SQLite may be used only for isolated tests that do not depend on MySQL-specific behavior.

## Frontend setup
Run `npm install`, `npm run dev` during development, and `npm run build` for production assets.

## Development server commands
Use `php artisan serve`, `npm run dev`, Laravel queues, and Laravel scheduler commands as needed after dependencies are installed.

## Test commands
Run `composer test` or `php artisan test`.

## Quality commands
Run `composer lint`, `composer analyse`, and `composer quality`.

## Build commands
Run `npm run build`.

## Current limitations
Dependency installation is blocked in this environment by package registry proxy restrictions. The scaffold documents intended Laravel 12 dependencies and files, but `vendor/` and `node_modules/` are not committed.

## Next phase
Phase 1 should add authentication, authorization policies, tenancy architecture decision records, and safe tenant context middleware without implementing financial posting logic.
