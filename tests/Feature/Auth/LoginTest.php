<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_guest_can_see_login(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>false]);
        $this->post(route('login.attempt'), ['email'=>$u->email,'password'=>'password'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
    }

    public function test_active_user_can_login(): void
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $this->post(route('login.attempt'), ['email'=>$u->email,'password'=>'password'])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($u);
    }

    public function test_wrong_password_returns_error(): void
    {
        $u = User::factory()->create(['password' => Hash::make('correct'), 'is_active' => true]);
        $this->from(route('login'))
            ->post(route('login.attempt'), ['email' => $u->email, 'password' => 'wrong'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_invalidates_session(): void
    {
        $u = User::factory()->create(['password' => Hash::make('password'), 'is_active' => true]);
        $this->actingAs($u);
        $this->post(route('logout'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_active_user_middleware_json_returns_403(): void
    {
        $u = User::factory()->create(['password' => Hash::make('password'), 'is_active' => false]);
        $this->actingAs($u)
            ->getJson(route('dashboard'))
            ->assertStatus(403)
            ->assertJsonFragment(['message' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
    }
}
