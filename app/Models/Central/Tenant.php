<?php

namespace App\Models\Central;

use App\Enums\TenantStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends CentralModel
{
    protected $fillable = ['name', 'slug', 'database_name'];

    public function domains(): HasMany { return $this->hasMany(Domain::class); }
    public function memberships(): HasMany { return $this->hasMany(TenantMembership::class); }
    public function invitations(): HasMany { return $this->hasMany(TenantInvitation::class); }
    public function provisioningAttempts(): HasMany { return $this->hasMany(ProvisioningAttempt::class); }

    public function scopeActive(Builder $query): Builder { return $query->where('status', TenantStatus::Active); }

    protected function casts(): array { return ['status' => TenantStatus::class, 'metadata' => 'array']; }
}
