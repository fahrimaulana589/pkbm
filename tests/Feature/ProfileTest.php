<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/admin/profile');

        $response->assertOk();
    }

    public function test_profile_name_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('update-profile-information-form', ['user' => $user])
            ->set('name', 'Test User Updated')
            ->set('email', $user->email)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated');

        $user->refresh();

        $this->assertSame('Test User Updated', $user->name);
        $this->assertSame($user->email, $user->email);
    }

    public function test_profile_email_update_requires_verification(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $newEmail = 'test-' . \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(10)) . '@example.com';

        Livewire::test('update-profile-information-form', ['user' => $user])
            ->set('name', 'Test User')
            ->set('email', $newEmail)
            ->call('submit')
            ->assertHasErrors(['email' => 'You need to verify your new email address.'])
            ->assertNotDispatched('profile-updated');

        $user->refresh();

        $this->assertNotSame($newEmail, $user->email);
    }

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('update-password-form', ['user' => $user])
            ->set('current_password', 'password')
            ->set('new_password', 'new-password')
            ->set('new_password_confirmation', 'new-password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('profile-updated-password');

        $this->assertTrue(auth()->validate([
            'email' => $user->email,
            'password' => 'new-password',
        ]));
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('delete-user-form', ['user' => $user])
            ->call('delete')
            ->assertRedirect(route('login'));

        $this->assertNull($user->fresh());
    }
}
