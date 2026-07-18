<?php

namespace App\Enums;

enum TenantStatus: string
{
    case Pending = 'pending';
    case Provisioning = 'provisioning';
    case ProvisioningFailed = 'provisioning_failed';
    case Trialing = 'trialing';
    case Active = 'active';
    case GracePeriod = 'grace_period';
    case Suspended = 'suspended';
    case Cancelled = 'cancelled';
    case Archived = 'archived';
}
