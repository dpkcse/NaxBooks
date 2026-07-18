<?php

namespace App\Models\Central;

use App\Enums\DomainStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends CentralModel
{
    protected $fillable = ['tenant_id', 'domain', 'type', 'is_primary'];
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    public function scopeVerified(Builder $query): Builder { return $query->where('status', DomainStatus::Verified); }
    protected function casts(): array { return ['status' => DomainStatus::class, 'is_primary' => 'boolean', 'is_verified' => 'boolean', 'verified_at' => 'datetime']; }
}
