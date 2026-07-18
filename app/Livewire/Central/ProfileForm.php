<?php
namespace App\Livewire\Central;
use Livewire\Component;
class ProfileForm extends Component{public string $name='';public string $email='';public function mount():void{$this->name=auth()->user()->name;$this->email=auth()->user()->email;}public function save():void{app(\App\Actions\Fortify\UpdateUserProfileInformation::class)->update(auth()->user(),$this->only('name','email'));session()->flash('status','Profile updated.');}public function render(){return view('livewire.central.profile-form');}}
