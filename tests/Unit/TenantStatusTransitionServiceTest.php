<?php

use App\Enums\TenantStatus;
use App\Services\PlatformAuditService;
use App\Services\TenantStatusTransitionService;

it('allows only documented tenant lifecycle transitions and makes archived terminal', function (): void {
    $service = new TenantStatusTransitionService(new PlatformAuditService);

    expect($service->canTransition(TenantStatus::Pending, TenantStatus::Provisioning))->toBeTrue()
        ->and($service->canTransition(TenantStatus::Pending, TenantStatus::Active))->toBeFalse()
        ->and($service->canTransition(TenantStatus::Archived, TenantStatus::Active))->toBeFalse();
});
