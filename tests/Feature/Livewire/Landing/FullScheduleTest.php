<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\ClassGroup;
use App\Models\Schedule;
use App\Models\Tutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class FullScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_full_schedule_page()
    {
        $response = $this->get('/jadwal');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.full-schedule');
    }

    public function test_can_display_schedules_in_correct_order()
    {
        $tutor = Tutor::factory()->create(['nama' => 'John Doe']);
        $classGroup = ClassGroup::factory()->create([
            'nama_rombel' => 'Kelas A',
            'tutor_id' => $tutor->id,
        ]);
        
        // Create schedule for Tuesday
        Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
            'hari' => 'Selasa',
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'materi' => 'Bahasa Indonesia',
        ]);

        // Create schedule for Monday
        Schedule::factory()->create([
            'rombel_id' => $classGroup->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'materi' => 'Matematika',
        ]);

        $component = Volt::test('landing.full-schedule');
        
        $component->assertSeeInOrder(['Senin', 'Matematika', 'Selasa', 'Bahasa Indonesia']);
    }
}
