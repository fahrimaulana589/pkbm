<?php

namespace Tests\Feature;

use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class TutorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_tutor_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.tutor.index'));

        $response->assertStatus(200);
        $response->assertSee('Tutor');
    }

    public function test_can_create_tutor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('tutor-form-create')
            ->set('nama', 'Test Tutor')
            ->set('no_hp', '08123456789')
            ->set('alamat', 'Jl. Test No. 1')
            ->set('pendidikan_terakhir', 'S1 Pendidikan')
            ->set('keahlian', 'Matematika')
            ->set('status', 'aktif')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.tutor.index'));

        $this->assertDatabaseHas('tutors', [
            'nama' => 'Test Tutor',
            'no_hp' => '08123456789',
        ]);
    }

    public function test_can_update_tutor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tutor = Tutor::factory()->create();

        Volt::test('tutor-form-edit', ['id' => $tutor->id])
            ->set('nama', 'Updated Tutor Name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('tutor-updated');

        $this->assertDatabaseHas('tutors', [
            'id' => $tutor->id,
            'nama' => 'Updated Tutor Name',
        ]);
    }

    public function test_can_delete_tutor()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tutor = Tutor::factory()->create();

        Volt::test('tutor-table')
            ->call('confirmDelete', $tutor->id)
            ->call('delete')
            ->assertDispatched('delete-tutor-confirmed');

        $this->assertDatabaseMissing('tutors', [
            'id' => $tutor->id,
        ]);
    }
}
