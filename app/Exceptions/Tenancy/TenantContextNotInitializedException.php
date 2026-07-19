<?php

namespace App\Exceptions\Tenancy;

use RuntimeException;

final class TenantContextNotInitializedException extends RuntimeException
{
    protected $message = 'Tenant context has not been initialized.';
}
