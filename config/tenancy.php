<?php
return [
    'central_domains' => array_values(array_filter(array_map('trim', explode(',', env('CENTRAL_DOMAINS', 'naxbooks.test'))))),
    'admin_domains' => array_values(array_filter(array_map('trim', explode(',', env('ADMIN_DOMAINS', 'admin.naxbooks.test'))))),
    'reserved_subdomains' => ['admin', 'app', 'api', 'www', 'support', 'mail', 'billing', 'status'],
    'tenant_connection' => 'tenant',
    'private_root' => 'private/tenants',
];
