<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProgramDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_program_detail_page()
    {
        $program = Program::factory()->create();

        $this->get('/program/' . $program->id)
            ->assertOk()
            ->assertSeeLivewire('landing.program-detail');
    }

    public function test_program_detail_displays_correct_data()
    {
        $program = Program::factory()->create([
            'nama_program' => 'Test Program',
            'kategori' => 'Paket A',
            'durasi' => '3 Bulan',
            'deskripsi' => 'This is a test description.',
        ]);

        Volt::test('landing.program-detail', ['id' => $program->id])
            ->assertSee('Test Program')
            ->assertSee('Paket A')
            ->assertSee('3 Bulan')
            ->assertSee('This is a test description.');
    }

    public function test_program_detail_has_back_button()
    {
        $program = Program::factory()->create();

        Volt::test('landing.program-detail', ['id' => $program->id])
            ->assertSee('Kembali ke Daftar Program')
            ->assertSee('href="/program"', false);
    }
    
    public function test_program_detail_has_cta_buttons()
    {
        $program = Program::factory()->create();

        Volt::test('landing.program-detail', ['id' => $program->id])
            ->assertSee('Daftar Sekarang')
            ->assertSee('Konsultasi via WA');
    }
}
