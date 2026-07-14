# Local development

1. Install PHP 8.2.12, Composer, Node.js, npm, MySQL 8+, and Redis.
2. Run `composer install`.
3. Run `cp .env.example .env` and `php artisan key:generate`.
4. Configure MySQL credentials in `.env`.
5. Run `php artisan storage:link` when public storage is needed.
6. Run `php artisan config:clear` and `php artisan cache:clear` after environment changes.
7. Run `npm install` and `npm run dev`.
