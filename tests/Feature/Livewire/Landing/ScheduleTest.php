<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\ClassGroup;
use App\Models\Schedule;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_schedule_component()
    {
        $component = Volt::test('landing.schedules');

        $component->assertStatus(200);
    }

    public function test_can_display_schedules_for_current_day()
    {
        // Mock current time to be Monday (Senin)
        $this->travelTo(Carbon::parse('2023-10-23 10:00:00')); // 23 Oct 2023 is a Monday

        $tutor = Tutor::factory()->create(['nama' => 'John Doe']);
        $classGroup = ClassGroup::factory()->create([
            'nama_rombel' => 'Kelas A',
            'tutor_id' => $tutor->id,
        ]);
        
        // Create schedule for Monday (Should be visible)
        Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'materi' => 'Matematika',
        ]);

        // Create schedule for Tuesday (Should NOT be visible)
        Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
            'hari' => 'Selasa',
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'materi' => 'Bahasa Indonesia',
        ]);

        $component = Volt::test('landing.schedules');
        
        $component->assertSee('Matematika')
            ->assertSee('08:00')
            ->assertSee('10:00')
            ->assertDontSee('Bahasa Indonesia')
            ->assertSee('Senin, 23 Oktober 2023');
    }

    public function test_shows_empty_state_when_no_schedules()
    {
        Volt::test('landing.schedules')
            ->assertSee('Belum ada jadwal');
    }
}
