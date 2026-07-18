<?php
namespace App\Services\Tenancy;
use App\Models\Central\Tenant;
final readonly class DomainResolutionResult { public function __construct(public string $host, public ?Tenant $tenant, public bool $platform = false) {} public function foundTenant(): bool { return $this->tenant !== null; } }
