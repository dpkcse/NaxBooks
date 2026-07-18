<?php

namespace App\Services;

use App\Models\Central\PlatformAuditLog;
use App\Models\Central\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PlatformAuditService
{
    private const SENSITIVE_FRAGMENTS = ['password', 'token', 'secret', 'cookie', 'session', 'app_key', 'authorization', 'database_url', 'db_password', 'database_password'];

    public function record(string $action, ?User $actor = null, ?Model $entity = null, ?Tenant $tenant = null, array $oldValues = [], array $newValues = [], ?string $reason = null, ?Request $request = null): PlatformAuditLog
    {
        return PlatformAuditLog::query()->create([
            'actor_user_id' => $actor?->id,
            'tenant_id' => $tenant?->id,
            'action' => $action,
            'entity_type' => $entity?->getMorphClass(),
            'entity_id' => $entity?->getKey(),
            'old_values' => $this->redact($oldValues),
            'new_values' => $this->redact($newValues),
            'reason' => $reason,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'request_id' => $request?->attributes->get('request_id'),
        ]);
    }

    public function redact(array $values): array
    {
        $redacted = [];
        foreach ($values as $key => $value) {
            $normalizedKey = strtolower((string) $key);
            $redacted[$key] = $this->isSensitive($normalizedKey) ? '[REDACTED]' : (is_array($value) ? $this->redact($value) : $value);
        }
        return $redacted;
    }

    private function isSensitive(string $key): bool
    {
        foreach (self::SENSITIVE_FRAGMENTS as $fragment) {
            if (str_contains($key, $fragment)) return true;
        }
        return false;
    }
}
