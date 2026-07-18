<?php
namespace App\Services\Tenancy;
use App\Enums\DomainStatus;
use App\Models\Central\Domain;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
final class ResolveTenantFromHost
{
 public function __construct(private NormalizeHost $normalize) {}
 public function __invoke(string $host): DomainResolutionResult { $host=($this->normalize)($host); $platform=array_map('strtolower', array_merge(config('tenancy.central_domains'),config('tenancy.admin_domains'))); if(in_array($host,$platform,true)) return new DomainResolutionResult($host,null,true); if (in_array(explode('.', $host)[0], config('tenancy.reserved_subdomains'), true)) throw new NotFoundHttpException('Tenant not found.'); $domain=Domain::query()->with('tenant')->where('domain',$host)->where('status',DomainStatus::Verified)->where('is_verified',true)->first(); if(!$domain || !$domain->tenant) throw new NotFoundHttpException('Tenant not found.'); return new DomainResolutionResult($host,$domain->tenant); }
}
