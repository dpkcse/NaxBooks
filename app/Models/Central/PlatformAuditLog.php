<?php

namespace App\Models\Central;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformAuditLog extends CentralModel
{
    public $timestamps = false;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::updating(static fn (): bool => false);
        static::deleting(static fn (): bool => false);
    }

    public function actor(): BelongsTo { return $this->belongsTo(User::class, 'actor_user_id'); }
    public function tenant(): BelongsTo { return $this->belongsTo(Tenant::class); }
    protected function casts(): array { return ['old_values' => 'array', 'new_values' => 'array', 'created_at' => 'datetime']; }
}
