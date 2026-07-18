<?php
namespace App\Models\Central;
use App\Enums\DomainStatus;use Illuminate\Database\Eloquent\Builder;use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Domain extends CentralModel{protected $fillable=['tenant_id','domain'];public function tenant():BelongsTo{return $this->belongsTo(Tenant::class);}public function scopeVerified(Builder $q):Builder{return $q->where('status',DomainStatus::Verified);}protected function casts():array{return ['status'=>DomainStatus::class,'verified_at'=>'datetime'];}}
