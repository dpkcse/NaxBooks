<?php
namespace App\Models\Central;
use App\Models\User;use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PlatformAuditLog extends CentralModel{public $timestamps=false;protected $fillable=['actor_user_id','action','auditable_type','auditable_id','ip_address','user_agent','request_id','metadata','created_at'];public function actor():BelongsTo{return $this->belongsTo(User::class,'actor_user_id');}protected function casts():array{return ['metadata'=>'array','created_at'=>'datetime'];}}
