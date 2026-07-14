<?php

return [
    'name' => env('APP_NAME', 'NAXAS Accounting'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://naxas.test'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Dhaka'),
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
    'version' => env('APP_VERSION', '0.1.0'),
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
];
