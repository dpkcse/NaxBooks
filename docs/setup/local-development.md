# Local development

## Requirements

Use PHP 8.2+, Composer, Node/npm, and a **disposable MariaDB 10.4.32+** database for schema validation. Production targets MySQL 8+. Do not run destructive migration commands against shared data.

## Central database configuration

1. Run `composer install`; if the lockfile does not yet contain Fortify, run `composer update laravel/fortify --with-all-dependencies` on a network-enabled machine and commit Composer's generated lockfile.
2. Copy `.env.example` to `.env` and run `php artisan key:generate`.
3. For Phase 1.2 local development, point `DB_*` and `CENTRAL_DB_*` at the same disposable database. This intentional alignment allows framework tables and explicitly central migrations to coexist locally.
4. Set all `CENTRAL_DB_*` values (`CONNECTION`, `HOST`, `PORT`, `DATABASE`, `USERNAME`, `PASSWORD`, and optional `SOCKET`). `SESSION_CONNECTION`, `CACHE_DB_CONNECTION`, and `QUEUE_DB_CONNECTION` default to `central`.
5. Use only non-destructive inspection first: `php artisan migrate:status` and `php artisan migrate --pretend`.
6. Install frontend dependencies with `npm install`, then run `npm run build`.

No tenant database configuration, switching, or provisioning execution is part of Phase 1.2.
