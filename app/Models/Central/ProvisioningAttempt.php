<?php

namespace App\Models\Central;

use App\Enums\ProvisioningAttemptStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProvisioningAttempt extends CentralModel
{
    protected $fillable = ['tenant_id', 'attempt_number', 'status', 'current_step', 'completed_steps', 'error_code', 'sanitized_error_message', 'initiated_by_user_id', 'request_id', 'started_at', 'completed_at', 'failed_at'];
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function initiator(): BelongsTo { return $this->belongsTo(User::class, 'initiated_by_user_id'); }
    protected function casts(): array { return ['status' => ProvisioningAttemptStatus::class, 'completed_steps' => 'array', 'started_at' => 'datetime', 'completed_at' => 'datetime', 'failed_at' => 'datetime']; }
}
