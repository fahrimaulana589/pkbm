<?php

namespace Tests\Feature;

use App\Models\ClassGroup;
use App\Models\Program;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ClassGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_class_group_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.rombel.index'));

        $response->assertStatus(200);
        $response->assertSee('Rombel');
    }

    public function test_can_create_class_group()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $tutor = Tutor::factory()->create(['status' => 'aktif']);

        Volt::test('class-group-form-create')
            ->set('program_id', $program->id)
            ->set('tutor_id', $tutor->id)
            ->set('nama_rombel', 'Test Rombel')
            ->set('periode', '2024/2025')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.rombel.index'));

        $this->assertDatabaseHas('class_groups', [
            'nama_rombel' => 'Test Rombel',
            'periode' => '2024/2025',
        ]);
    }

    public function test_can_update_class_group()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $tutor = Tutor::factory()->create(['status' => 'aktif']);
        $classGroup = ClassGroup::factory()->create([
            'program_id' => $program->id,
            'tutor_id' => $tutor->id,
        ]);

        Volt::test('class-group-form-edit', ['id' => $classGroup->id])
            ->set('nama_rombel', 'Updated Rombel Name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('class-group-updated');

        $this->assertDatabaseHas('class_groups', [
            'id' => $classGroup->id,
            'nama_rombel' => 'Updated Rombel Name',
        ]);
    }

    public function test_can_delete_class_group()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['status' => 'aktif']);
        $tutor = Tutor::factory()->create(['status' => 'aktif']);
        $classGroup = ClassGroup::factory()->create([
            'program_id' => $program->id,
            'tutor_id' => $tutor->id,
        ]);

        Volt::test('class-group-table')
            ->call('confirmDelete', $classGroup->id)
            ->call('delete')
            ->assertDispatched('delete-class-group-confirmed');

        $this->assertDatabaseMissing('class_groups', [
            'id' => $classGroup->id,
        ]);
    }
}
