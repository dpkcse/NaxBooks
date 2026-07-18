<?php
namespace App\Models\Tenant;
use App\Enums\{BusinessType,CompanyStatus}; use Illuminate\Database\Eloquent\Relations\HasMany;
class Company extends TenantModel { protected $guarded=[]; protected function casts():array{return ['business_type'=>BusinessType::class,'status'=>CompanyStatus::class,'is_default'=>'boolean'];} public function branches():HasMany{return $this->hasMany(Branch::class);} }
