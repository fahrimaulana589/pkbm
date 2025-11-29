<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        Livewire::test('form-forgot-password')
            ->set('email', $user->email)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('password-reset-link-sent');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $token = 'valid-token';

        $response = $this->get('/reset-password/'.$token);

        $response->assertStatus(200);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $token = app('auth.password.broker')->createToken($user);

        Livewire::test('form-reset-password', ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertTrue(auth()->guard()->attempt([
            'email' => $user->email,
            'password' => 'password',
        ]));
    }
}
