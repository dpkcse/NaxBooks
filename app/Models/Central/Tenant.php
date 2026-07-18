<?php

namespace App\Models\Central;

use App\Enums\TenantStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends CentralModel
{
    protected $fillable = ['name', 'slug', 'database_name', 'owner_user_id', 'settings'];

    public function owner(): BelongsTo { return $this->belongsTo(User::class, 'owner_user_id'); }
    public function domains(): HasMany { return $this->hasMany(Domain::class); }
    public function memberships(): HasMany { return $this->hasMany(TenantMembership::class); }
    public function invitations(): HasMany { return $this->hasMany(TenantInvitation::class); }
    public function provisioningAttempts(): HasMany { return $this->hasMany(ProvisioningAttempt::class); }
    public function scopeActive(Builder $query): Builder { return $query->where('status', TenantStatus::Active); }

    protected function casts(): array
    {
        return ['status' => TenantStatus::class, 'settings' => 'array', 'trial_starts_at' => 'datetime', 'trial_ends_at' => 'datetime', 'activated_at' => 'datetime', 'suspended_at' => 'datetime', 'cancelled_at' => 'datetime', 'archived_at' => 'datetime', 'provisioning_completed_at' => 'datetime'];
    }
}
