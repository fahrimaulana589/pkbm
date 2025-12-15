<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\ClassGroup;
use App\Models\Program;
use App\Models\Tutor;
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

    public function test_can_display_list_of_classes()
    {
        $program = Program::factory()->create(['nama_program' => 'Paket A']);
        $tutor = Tutor::factory()->create(['nama' => 'John Doe']);
        
        ClassGroup::factory()->create([
            'nama_rombel' => 'Kelas A',
            'program_id' => $program->id,
            'tutor_id' => $tutor->id,
            'periode' => '2023/2024'
        ]);

        ClassGroup::factory()->create([
            'nama_rombel' => 'Kelas B',
            'program_id' => $program->id,
            'tutor_id' => $tutor->id,
            'periode' => '2023/2024'
        ]);

        $component = Volt::test('landing.schedules');
        
        $component->assertSee('Kelas A')
            ->assertSee('Kelas B')
            ->assertSee('Paket A')
            ->assertSee('John Doe')
            ->assertSee('Jadwal Kelas');
    }

    public function test_shows_empty_state_when_no_classes()
    {
        Volt::test('landing.schedules')
            ->assertSee('Belum ada kelas');
    }
}
