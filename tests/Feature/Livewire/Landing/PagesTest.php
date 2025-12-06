<?php

namespace Tests\Feature\Livewire\Landing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_profile_page()
    {
        $response = $this->get('/profil');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.profile');
    }

    public function test_profile_page_shows_full_data()
    {
        $profile = \App\Models\PkbmProfile::first();
        if (!$profile) {
            $profile = \App\Models\PkbmProfile::create([
                'nama_pkbm' => 'PKBM Test',
                'npsn' => '12345678',
                'alamat' => 'Alamat Test',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Coblong',
                'desa' => 'Dago',
                'telepon' => '08123456789',
                'email' => 'test@pkbm.com',
                'kepala_pkbm' => 'Kepala Test',
                'visi' => 'Visi Test',
                'misi' => 'Misi Test',
                'kata_sambutan' => 'Sambutan Test',
            ]);
        } else {
            $profile->update([
                'npsn' => '12345678',
                'kepala_pkbm' => 'Kepala Test',
                'kata_sambutan' => 'Sambutan Test',
            ]);
        }

        $component = \Livewire\Volt\Volt::test('landing.profile', ['isFullPage' => true]);
        
        $component->assertSee('12345678'); // NPSN
        $component->assertSee('Kepala Test'); // Kepala PKBM
        $component->assertSee('Sambutan Test'); // Kata Sambutan
    }

    public function test_can_render_program_page()
    {
        $response = $this->get('/program');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.programs');
    }

    public function test_program_page_shows_full_description()
    {
        $longDescription = str_repeat('A', 200);
        \App\Models\Program::create([
            'nama_program' => 'Program Test',
            'deskripsi' => $longDescription,
            'kategori' => 'Paket A',
            'status' => 'aktif',
        ]);

        $component = \Livewire\Volt\Volt::test('landing.programs', ['limitDescription' => false]);
        
        $component->assertSee($longDescription);
    }

    public function test_program_page_shows_duration()
    {
        \App\Models\Program::create([
            'nama_program' => 'Program Duration Test',
            'deskripsi' => 'Description',
            'kategori' => 'Paket B',
            'durasi' => '6 Bulan',
            'status' => 'aktif',
        ]);

        $component = \Livewire\Volt\Volt::test('landing.programs');
        
        $component->assertSee('6 Bulan');
    }

    public function test_can_render_tutor_page()
    {
        $response = $this->get('/tutor');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.tutor-index');
    }

    public function test_tutor_page_shows_education()
    {
        \App\Models\Tutor::create([
            'nama' => 'Tutor Test',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat Test',
            'pendidikan_terakhir' => 'S1 Pendidikan',
            'keahlian' => 'Matematika',
            'status' => 'aktif',
        ]);

        $component = \Livewire\Volt\Volt::test('landing.tutor-index');
        
        $component->assertSee('S1 Pendidikan');
    }

    public function test_can_render_announcement_page()
    {
        $response = $this->get('/pengumuman');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.announcement-index');
    }

    public function test_can_render_gallery_page()
    {
        $response = $this->get('/galeri');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.gallery-index');
    }
}
