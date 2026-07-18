<?php
namespace App\Models\Tenant;
use App\Enums\BranchStatus; use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Branch extends TenantModel { protected $guarded=[]; protected function casts():array{return ['status'=>BranchStatus::class,'is_default'=>'boolean'];} public function company():BelongsTo{return $this->belongsTo(Company::class);} }
