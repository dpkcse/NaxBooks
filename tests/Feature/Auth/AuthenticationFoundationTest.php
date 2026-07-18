<?php
use App\Enums\UserStatus;use App\Models\User;
it('rejects disabled central users during authentication',function(){$user=User::factory()->create(['email'=>'disabled@example.com','password'=>'password','status'=>UserStatus::Disabled]);$this->post('/login',['email'=>$user->email,'password'=>'password'])->assertSessionHasErrors();$this->assertGuest();});
it('regenerates and invalidates session on logout',function(){$user=User::factory()->create();$this->actingAs($user)->post('/logout')->assertRedirect('/');$this->assertGuest();});
