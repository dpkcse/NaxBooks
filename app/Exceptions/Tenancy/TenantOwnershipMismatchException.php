<?php

namespace App\Exceptions\Tenancy;

use RuntimeException;

final class TenantOwnershipMismatchException extends RuntimeException
{
    protected $message = 'The resource does not belong to the current tenant.';
}
