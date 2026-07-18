<?php
namespace App\Models\Central;
use App\Models\User;use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TenantInvitation extends CentralModel{protected $fillable=['tenant_id','email','role','invited_by_user_id','token_hash','expires_at'];protected $hidden=['token_hash'];public function tenant():BelongsTo{return $this->belongsTo(Tenant::class);}public function inviter():BelongsTo{return $this->belongsTo(User::class,'invited_by_user_id');}protected function casts():array{return ['accepted_at'=>'datetime','expires_at'=>'datetime'];}}
