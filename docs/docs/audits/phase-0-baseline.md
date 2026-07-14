# Phase 0 baseline audit

## 1. Executive summary
Foundation files were scaffolded, but full Laravel installation could not complete because registry access is blocked by the environment proxy.

## 2. Initial repository state
`pwd` returned `/workspace/NaxBooks`. Initial files were `.git/` and `.gitkeep`. Git branch was `work`; working tree was clean; no remotes were configured.

## 3. Detected tool versions
PHP: 8.5.7-dev, not exactly target PHP 8.2.12. Composer: 2.9.7. Node: v24.15.0. npm: 11.4.2. MySQL and Redis CLIs were not installed.

## 4. Laravel installation result
`composer create-project laravel/laravel:^12.0` failed because `repo.packagist.org` returned proxy 403. Composer platform PHP is declared as 8.2.12 in `composer.json`.

## 5. Installed backend dependencies
No backend dependencies were downloaded. Intended dependencies are Laravel 12, Livewire 3, Pint, Larastan, Pest, and Pest Laravel plugin.

## 6. Installed frontend dependencies
No frontend dependencies were downloaded. Intended dependencies are Vite, Laravel Vite plugin, Tailwind CSS, Alpine.js, Axios, and Concurrently.

## 7. Environment configuration status
`.env.example` contains safe placeholders and no real credentials.

## 8. Current route inventory
Planned routes are `GET /`, `GET /dashboard`, and `GET /health`.

## 9. Current directory architecture
Action, Data, Domain, Enum, Exception, Livewire, Policy, Service, Support, and target domain namespace directories were prepared with `.gitkeep` markers only.

## 10. Frontend baseline
Blade layouts, reusable components, Alpine entrypoint, Tailwind CSS entrypoint, and Vite config were created.

## 11. Testing baseline
Pest-style tests were added, but cannot run until Composer dependencies are installed.

## 12. Static-analysis baseline
`phpstan.neon` uses Larastan at level 5, pending vendor installation.

## 13. Security baseline
`.env` is ignored, `.env.example` uses placeholders, health route is designed to avoid secrets, CSRF remains Laravel-default once framework is installed, and no auth bypass package was added.

## 14. Performance baseline
Vite production build and Laravel cache commands are documented; actual validation is blocked by missing dependencies.

## 15. Known limitations
The environment uses PHP 8.5.7-dev rather than PHP 8.2.12, and package downloads are blocked.

## 16. Failed commands
- `composer create-project laravel/laravel:^12.0 . --no-interaction`: directory not empty because `.git` exists.
- `composer create-project laravel/laravel:^12.0 /tmp/... --no-interaction`: proxy 403 from Packagist.
- Direct Composer without proxy: DNS resolution failed.

## 17. Critical blockers
Network/package registry access blocks real Laravel installation and dependency validation.

## 18. High-priority warnings
PHP version differs from target. MySQL and Redis CLIs are unavailable.

## 19. Phase 1 readiness checklist
Resolve package access, install dependencies, run full test/quality/build commands, then proceed to authentication and tenancy ADRs.

## 20. Recommendation
CONDITIONAL GO only after Composer/npm dependencies can be installed and validation commands pass.

## Additional validation notes
`composer install` failed with the same Packagist proxy 403. `npm install` failed with registry 403 for `@tailwindcss/vite`. `npm run build` failed because Vite is not installed. These are environment blockers, not hidden test failures.
