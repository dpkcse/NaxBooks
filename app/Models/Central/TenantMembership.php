<?php

namespace App\Models\Central;

use App\Enums\MembershipStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantMembership extends CentralModel
{
    protected $fillable = ['tenant_id', 'user_id', 'role_key'];
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function scopeActive(Builder $query): Builder { return $query->where('status', MembershipStatus::Active); }
    protected function casts(): array { return ['status' => MembershipStatus::class, 'joined_at' => 'datetime', 'suspended_at' => 'datetime']; }
}
