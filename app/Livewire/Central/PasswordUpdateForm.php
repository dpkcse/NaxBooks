<?php
namespace App\Livewire\Central;
use Livewire\Component;
class PasswordUpdateForm extends Component{public string $current_password='';public string $password='';public string $password_confirmation='';public function save():void{app(\App\Actions\Fortify\UpdateUserPassword::class)->update(auth()->user(),$this->only('current_password','password','password_confirmation'));$this->reset('current_password','password','password_confirmation');session()->flash('password-status','Password updated.');}public function render(){return view('livewire.central.password-update-form');}}
