# Testing and quality

Pest is preferred and declared for installation. Baseline commands are `php artisan test`, `vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `composer quality`, and `npm run build`. Accounting and tenancy integration tests should use MySQL when database behavior matters; SQLite in-memory is acceptable only for isolated framework tests.
