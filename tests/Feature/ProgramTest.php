<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_program_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.program.index'));

        $response->assertStatus(200);
        $response->assertSee('Program Pendidikan');
    }

    public function test_can_create_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('program-form-create')
            ->set('nama_program', 'Test Program')
            ->set('kategori', 'Paket C')
            ->set('deskripsi', 'Deskripsi Test')
            ->set('durasi', '12 Bulan')
            ->set('status', 'aktif')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.program.index'));

        $this->assertDatabaseHas('programs', [
            'nama_program' => 'Test Program',
            'kategori' => 'Paket C',
        ]);
    }

    public function test_can_update_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create();

        Volt::test('program-form-edit', ['id' => $program->id])
            ->set('nama_program', 'Updated Program Name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('program-updated');

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'nama_program' => 'Updated Program Name',
        ]);
    }

    public function test_can_delete_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create();

        Volt::test('program-table')
            ->call('confirmDelete', $program->id)
            ->call('delete')
            ->assertDispatched('delete-program-confirmed');

        $this->assertDatabaseMissing('programs', [
            'id' => $program->id,
        ]);
    }
}
