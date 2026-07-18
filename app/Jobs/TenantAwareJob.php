<?php
namespace App\Jobs;
interface TenantAwareJob { public function tenantId(): int|string; }
