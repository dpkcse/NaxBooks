<?php

namespace App\Exceptions\Tenancy;

use RuntimeException;

final class TenantContextConflictException extends RuntimeException
{
    protected $message = 'Tenant context is already initialized for another tenant.';
}
