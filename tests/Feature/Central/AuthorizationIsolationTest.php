<?php
use App\Models\User;
it('blocks non platform administrators from platform routes',function(){$user=User::factory()->create(['is_platform_admin'=>false]);$this->actingAs($user)->get('/platform/dashboard')->assertForbidden();});
it('allows platform administrators into isolated platform routes',function(){$user=User::factory()->create(['is_platform_admin'=>true,'email_verified_at'=>now()]);$this->actingAs($user)->get('/platform/dashboard')->assertOk();});
