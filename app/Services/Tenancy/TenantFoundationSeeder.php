<?php
namespace App\Services\Tenancy;
use App\Models\Tenant\{Currency,TenantAuditLog};
final class TenantFoundationSeeder { public function __invoke(?int $actor=null):void { foreach([['code'=>'BDT','name'=>'Bangladeshi Taka','symbol'=>'৳'],['code'=>'USD','name'=>'US Dollar','symbol'=>'$']] as $currency) Currency::query()->updateOrCreate(['code'=>$currency['code']],$currency+['decimal_places'=>2,'is_base'=>$currency['code']==='BDT','is_active'=>true]); TenantAuditLog::query()->create(['actor_user_id'=>$actor,'action'=>'tenant.foundation_seeded','created_at'=>now()]); } }
