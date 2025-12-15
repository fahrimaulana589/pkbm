<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\ClassGroup;
use App\Models\Program;
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

    public function test_default_view_shows_class_list()
    {
        $program = Program::factory()->create(['nama_program' => 'Paket A']);
        $tutor = Tutor::factory()->create(['nama' => 'John Doe']);
        
        ClassGroup::factory()->create([
            'nama_rombel' => 'Kelas A',
            'program_id' => $program->id,
            'tutor_id' => $tutor->id,
        ]);

        $component = Volt::test('landing.full-schedule');
        
        $component->assertSee('Pilih Kelas')
            ->assertSee('Daftar Kelas Tersedia')
            ->assertSee('Kelas A')
            ->assertDontSee('Jadwal Kegiatan Belajar Mengajar'); 
    }

    public function test_can_filter_schedules_by_class()
    {
        $tutor = Tutor::factory()->create(['nama' => 'John Doe']);
        $classGroupA = ClassGroup::factory()->create(['nama_rombel' => 'Kelas A', 'tutor_id' => $tutor->id]);
        $classGroupB = ClassGroup::factory()->create(['nama_rombel' => 'Kelas B', 'tutor_id' => $tutor->id]);
        
        // Schedule for Class A
        Schedule::factory()->create([
            'rombel_id' => $classGroupA->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'materi' => 'Matematika A',
        ]);

        // Schedule for Class B
        Schedule::factory()->create([
            'rombel_id' => $classGroupB->id,
            'hari' => 'Senin',
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'materi' => 'Matematika B',
        ]);

        // Test with Class A filter
        Volt::test('landing.full-schedule', ['classId' => $classGroupA->id])
            ->assertSee('Matematika A')
            ->assertDontSee('Matematika B')
            ->assertSee('Jadwal Kelas')
            ->assertSee('Kelas A');

        // Test with Class B filter
        Volt::test('landing.full-schedule', ['classId' => $classGroupB->id])
            ->assertSee('Matematika B')
            ->assertDontSee('Matematika A')
            ->assertSee('Jadwal Kelas')
            ->assertSee('Kelas B');
    }
}
