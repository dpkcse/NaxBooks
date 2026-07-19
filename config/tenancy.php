<?php
return [
    'central_domains' => array_values(array_filter(array_map('trim', explode(',', env('CENTRAL_DOMAINS', 'naxbooks.test'))))),
    'admin_domains' => array_values(array_filter(array_map('trim', explode(',', env('ADMIN_DOMAINS', 'admin.naxbooks.test'))))),
    'tenant_root_domain' => env('TENANT_ROOT_DOMAIN', env('CENTRAL_DOMAIN', 'naxbooks.test')),
    'provisioning_mode' => env('TENANT_PROVISIONING_MODE', 'sync'),
    'reserved_subdomains' => ['admin', 'app', 'api', 'www', 'support', 'mail', 'billing', 'status', 'dashboard', 'login', 'register', 'auth', 'system', 'central', 'platform', 'root'],
    'tenant_connection' => 'tenant',
    'private_root' => 'private/tenants',
];
