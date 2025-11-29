<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        Livewire::test('form-login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        Livewire::test('form-login')
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('submit')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('user-logout')
            ->call('submit')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
