<?php
namespace App\Services\Tenancy;
use App\Models\Central\Tenant; use DomainException;
final class TenantDatabaseName { public function for(Tenant $tenant):string { $environment=preg_replace('/[^a-z0-9_]/','_',strtolower((string)config('app.env','local'))); $name='nax_tenant_'.$environment.'_'.str_pad(dechex($tenant->getKey()),12,'0',STR_PAD_LEFT); if(!preg_match('/\A[a-z0-9_]{1,64}\z/',$name)) throw new DomainException('Invalid tenant database identifier.'); return $name;} public function quote(string $name):string {if(!preg_match('/\A[a-z0-9_]{1,64}\z/',$name))throw new DomainException('Invalid tenant database identifier.');return '`'.$name.'`';} }
