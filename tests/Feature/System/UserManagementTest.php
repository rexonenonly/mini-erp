<?php
namespace Tests\Feature\System;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    private function owner(): User
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole('Owner');
        return $u;
    }

    public function test_owner_can_create_user(): void
    {
        $this->actingAs($this->owner());
        $this->get(route('system.users.create'))->assertOk();
        $this->post(route('system.users.store'), [
            'name'=>'Test','email'=>'test@minierp.test','password'=>'password123','password_confirmation'=>'password123','role'=>'Staf Gudang','is_active'=>1
        ])->assertRedirect(route('system.users'));
        $this->assertDatabaseHas('users',['email'=>'test@minierp.test','is_active'=>true]);
    }

    public function test_cannot_deactivate_self(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);
        $this->patch(route('system.users.status', $owner))
            ->assertRedirect()
            ->assertSessionHasErrors('status');
    }

    public function test_cannot_remove_last_owner(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);
        $this->put(route('system.users.update', $owner), [
            'name'=>$owner->name,'email'=>$owner->email,'role'=>'Staf Gudang','is_active'=>1
        ])->assertRedirect()->assertSessionHasErrors('role');
    }

    public function test_non_owner_cannot_assign_owner_role(): void
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole('Staf Gudang');
        $this->actingAs($u);
        $this->post(route('system.users.store'), [
            'name'=>'X','email'=>'x@minierp.test','password'=>'password123','password_confirmation'=>'password123','role'=>'Owner','is_active'=>1
        ])->assertForbidden();
    }

    public function test_inactive_user_session_ended(): void
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole('Staf Gudang');
        $this->actingAs($u);
        $this->get(route('dashboard'))->assertOk();
        $u->update(['is_active'=>false]);
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_password_stored_hashed(): void
    {
        $this->actingAs($this->owner());
        $this->post(route('system.users.store'), [
            'name'=>'Hash','email'=>'hash@minierp.test','password'=>'password123','password_confirmation'=>'password123','role'=>'Staf Gudang','is_active'=>1
        ]);
        $u = User::where('email','hash@minierp.test')->first();
        $this->assertNotNull($u);
        $this->assertNotEquals('password123', $u->password);
        $this->assertTrue(password_verify('password123', $u->password));
    }
}
