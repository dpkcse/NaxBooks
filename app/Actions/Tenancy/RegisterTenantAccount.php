<?php
namespace App\Actions\Tenancy;
use App\Enums\{DomainStatus,MembershipStatus,TenantStatus,UserStatus};
use App\Models\{Central\Domain,Central\Tenant,Central\TenantMembership,User};
use App\Services\{PlatformAuditService}; use App\Services\Tenancy\{TenantDatabaseName,TenantProvisioner};
use Illuminate\Support\Facades\{Auth,DB,Hash}; use Illuminate\Support\Str; use Illuminate\Validation\ValidationException;
final class RegisterTenantAccount {
 public function __construct(private TenantDatabaseName $databaseNames,private TenantProvisioner $provisioner,private PlatformAuditService $audit){}
 public function register(array $data, ?User $authenticatedUser=null): Tenant {
  $email=Str::lower(trim($data['email'])); $host=$this->host($data['subdomain']);
  $tenant=DB::connection('central')->transaction(function()use($data,$email,$host,$authenticatedUser){
   $user=User::query()->where('email',$email)->lockForUpdate()->first();
   if($user&&!$authenticatedUser)throw ValidationException::withMessages(['email'=>'Please sign in to create another workspace with this email.']);
   if($user&&$authenticatedUser->id!==$user->id)throw ValidationException::withMessages(['email'=>'Please sign in to continue.']);
   if($user?->status===UserStatus::Disabled)throw ValidationException::withMessages(['email'=>'This account cannot create a workspace.']);
   $user??=User::query()->create(['name'=>$data['name'],'email'=>$email,'password'=>Hash::make($data['password'])]);
   if(Domain::query()->where('domain',$host)->exists())throw ValidationException::withMessages(['subdomain'=>'This workspace name is unavailable.']);
   $slug=Str::slug($data['legal_name']).'-'.Str::lower($data['subdomain']);
   $tenant=new Tenant(['name'=>$data['display_name']?:$data['legal_name'],'slug'=>$slug,'owner_user_id'=>$user->id,'settings'=>['business_type'=>$data['business_type'],'country'=>$data['country'],'timezone'=>$data['timezone'],'base_currency'=>$data['base_currency']]]);$tenant->database_name=$this->databaseNames->for($tenant);$tenant->status=TenantStatus::Pending;$tenant->trial_starts_at=now();$tenant->trial_ends_at=now()->addDays(14);$tenant->save();
   Domain::query()->create(['tenant_id'=>$tenant->id,'domain'=>$host,'type'=>'platform','status'=>DomainStatus::Verified,'is_primary'=>true,'is_verified'=>true,'verified_at'=>now()]);
   TenantMembership::query()->create(['tenant_id'=>$tenant->id,'user_id'=>$user->id,'role_key'=>'owner','status'=>MembershipStatus::Active,'joined_at'=>now()]);
   $this->audit->record('tenant.registration.central_created',$user,$tenant,$tenant,null,['request_id'=>request()?->attributes->get('request_id')]); return $tenant;
  });
  if(!$authenticatedUser)Auth::loginUsingId($tenant->owner_user_id);
  if(config('tenancy.provisioning_mode')==='sync')$this->provisioner->provision($tenant,$tenant->owner_user_id,request()?->attributes->get('request_id'));
  return $tenant->fresh();
 }
 public function host(string $subdomain):string { $subdomain=Str::lower(trim($subdomain));if(!preg_match('/^[a-z0-9](?:[a-z0-9-]{1,61}[a-z0-9])$/',$subdomain)||in_array($subdomain,config('tenancy.reserved_subdomains'),true))throw ValidationException::withMessages(['subdomain'=>'This workspace name is invalid.']);return $subdomain.'.'.config('tenancy.tenant_root_domain'); }
}
