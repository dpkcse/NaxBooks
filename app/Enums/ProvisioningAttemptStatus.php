<?php

namespace App\Enums;

enum ProvisioningAttemptStatus: string
{
    case Started = 'started';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Failed = 'failed';
}
