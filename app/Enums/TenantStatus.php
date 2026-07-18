<?php

namespace App\Enums;

enum TenantStatus: string
{
    case PendingProvisioning = 'pending_provisioning';
    case Provisioning = 'provisioning';
    case Active = 'active';
    case Suspended = 'suspended';
    case Archived = 'archived';
}
