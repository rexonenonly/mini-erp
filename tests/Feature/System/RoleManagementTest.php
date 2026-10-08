<?php
namespace Tests\Feature\System;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    private function owner(): User
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole('Owner');
        return $u;
    }

    public function test_owner_can_edit_role_permissions(): void
    {
        $this->actingAs($this->owner());
        $role = Role::findByName('Staf Gudang');
        $this->get(route('system.roles.edit', $role))->assertOk();
        $this->put(route('system.roles.update', $role), [
            'permissions'=>['products.view','stock.view']
        ])->assertRedirect(route('system.roles'));
        $this->assertTrue($role->fresh()->hasPermissionTo('products.view'));
    }

    public function test_owner_role_is_immutable(): void
    {
        $this->actingAs($this->owner());
        $role = Role::findByName('Owner');
        $this->put(route('system.roles.update', $role), ['permissions'=>[]])
            ->assertRedirect(route('system.roles'));
        $this->assertTrue($role->fresh()->hasPermissionTo('products.view'));
    }

    public function test_seeded_roles_cannot_be_deleted(): void
    {
        $this->actingAs($this->owner());
        $role = Role::findByName('Staf Gudang');
        $this->delete(route('system.roles.destroy', $role))
            ->assertRedirect()
            ->assertSessionHasErrors('role');
    }

    public function test_custom_role_with_users_cannot_be_deleted(): void
    {
        $this->actingAs($this->owner());
        $role = Role::create(['name'=>'Custom','guard_name'=>'web']);
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole('Custom');
        $this->delete(route('system.roles.destroy', $role))
            ->assertRedirect()
            ->assertSessionHasErrors('role');
    }

    public function test_permission_dependency_enforced(): void
    {
        $this->actingAs($this->owner());
        $role = Role::findByName('Staf Gudang');
        $this->put(route('system.roles.update', $role), [
            'permissions'=>['products.create']
        ])->assertRedirect(route('system.roles'));
        $this->assertTrue($role->fresh()->hasPermissionTo('products.view'));
    }
}
