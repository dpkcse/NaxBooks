<?php
namespace App\Models\Central;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProvisioningAttempt extends CentralModel{protected $fillable=['tenant_id','status','attempt','message','started_at','finished_at'];public function tenant():BelongsTo{return $this->belongsTo(Tenant::class);}protected function casts():array{return ['context'=>'array','started_at'=>'datetime','finished_at'=>'datetime'];}}
