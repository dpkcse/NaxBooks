<?php
namespace App\Actions\Fortify;
use Illuminate\Support\Facades\Validator;use Laravel\Fortify\Contracts\ResetsUserPasswords;
class ResetUserPassword implements ResetsUserPasswords{public function reset($user,array $input):void{Validator::make($input,['password'=>['required','string','min:8','confirmed']])->validate();$user->forceFill(['password'=>$input['password']])->save();}}
