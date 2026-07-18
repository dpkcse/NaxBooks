<?php
namespace App\Jobs\Middleware;
use App\Enums\TenantStatus; use App\Jobs\TenantAwareJob; use App\Models\Central\Tenant; use App\Tenancy\TenantContextManager;
final class InitializeTenantContext { public function handle(object $job, callable $next): mixed { if(!$job instanceof TenantAwareJob) return $next($job); $tenant=Tenant::query()->find($job->tenantId()); if(!$tenant || !in_array($tenant->status,[TenantStatus::Trialing,TenantStatus::Active,TenantStatus::GracePeriod],true)) return null; $manager=app(TenantContextManager::class); $manager->initialize($tenant); try{return $next($job);} finally {$manager->clear();} } }
