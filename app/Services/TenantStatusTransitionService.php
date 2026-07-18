<?php

namespace App\Services;

use App\Enums\TenantStatus;
use App\Models\Central\Tenant;
use App\Models\User;
use DomainException;
use Illuminate\Http\Request;

class TenantStatusTransitionService
{
    private const ALLOWED = [
        'pending' => [TenantStatus::Provisioning, TenantStatus::Cancelled],
        'provisioning' => [TenantStatus::Trialing, TenantStatus::Active, TenantStatus::ProvisioningFailed],
        'provisioning_failed' => [TenantStatus::Provisioning, TenantStatus::Cancelled, TenantStatus::Archived],
        'trialing' => [TenantStatus::Active, TenantStatus::GracePeriod, TenantStatus::Suspended, TenantStatus::Cancelled],
        'active' => [TenantStatus::GracePeriod, TenantStatus::Suspended, TenantStatus::Cancelled],
        'grace_period' => [TenantStatus::Active, TenantStatus::Suspended, TenantStatus::Cancelled],
        'suspended' => [TenantStatus::Active, TenantStatus::Cancelled, TenantStatus::Archived],
        'cancelled' => [TenantStatus::Archived],
        'archived' => [],
    ];

    public function __construct(private readonly PlatformAuditService $audit) {}

    public function transition(Tenant $tenant, TenantStatus $to, ?User $actor = null, ?string $reason = null, ?Request $request = null): Tenant
    {
        $from = $tenant->status;
        if (! $this->canTransition($from, $to)) {
            throw new DomainException("Tenant status transition from {$from->value} to {$to->value} is not allowed.");
        }

        $tenant->forceFill(array_filter(['status' => $to] + $this->timestampUpdates($to)))->save();
        $this->audit->record('tenant.status_transitioned', $actor, $tenant, $tenant, ['status' => $from->value], ['status' => $to->value], $reason, $request);

        return $tenant;
    }

    public function canTransition(TenantStatus $from, TenantStatus $to): bool
    {
        return in_array($to, self::ALLOWED[$from->value] ?? [], true);
    }

    private function timestampUpdates(TenantStatus $status): array
    {
        return match ($status) {
            TenantStatus::Trialing => ['trial_starts_at' => now(), 'provisioning_completed_at' => now()],
            TenantStatus::Active => ['activated_at' => now()],
            TenantStatus::Suspended => ['suspended_at' => now()],
            TenantStatus::Cancelled => ['cancelled_at' => now()],
            TenantStatus::Archived => ['archived_at' => now()],
            default => [],
        };
    }
}
