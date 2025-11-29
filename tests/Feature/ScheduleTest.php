<?php

namespace Tests\Feature;

use App\Models\ClassGroup;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_schedule_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.jadwal.index'));

        $response->assertStatus(200);
        $response->assertSee('Jadwal Belajar');
    }

    public function test_can_create_schedule()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $classGroup = ClassGroup::factory()->create();

        Volt::test('schedule-form-create')
            ->set('rombel_id', $classGroup->id)
            ->set('hari', 'Senin')
            ->set('jam_mulai', '08:00')
            ->set('jam_selesai', '10:00')
            ->set('materi', 'Matematika Dasar')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.jadwal.index'));

        $this->assertDatabaseHas('schedules', [
            'hari' => 'Senin',
            'materi' => 'Matematika Dasar',
        ]);
    }

    public function test_can_update_schedule()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $classGroup = ClassGroup::factory()->create();
        $schedule = Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
        ]);

        Volt::test('schedule-form-edit', ['id' => $schedule->id])
            ->set('materi', 'Updated Materi')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('schedule-updated');

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'materi' => 'Updated Materi',
        ]);
    }

    public function test_can_delete_schedule()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $classGroup = ClassGroup::factory()->create();
        $schedule = Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
        ]);

        Volt::test('schedule-table')
            ->call('confirmDelete', $schedule->id)
            ->call('delete')
            ->assertDispatched('delete-schedule-confirmed');

        $this->assertDatabaseMissing('schedules', [
            'id' => $schedule->id,
        ]);
    }
}
