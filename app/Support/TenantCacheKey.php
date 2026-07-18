<?php
namespace App\Support;
use App\Tenancy\TenantContext;
final class TenantCacheKey { public function make(string $key): string { if($key==='' || str_contains($key,'..')) throw new \InvalidArgumentException('Invalid tenant cache key.'); return 'tenant:'.app(TenantContext::class)->id().':'.$key; } public function central(string $key): string { return 'central:'.$key; } }
