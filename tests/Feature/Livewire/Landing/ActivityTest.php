<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_activities_page()
    {
        $this->get('/kegiatan')
            ->assertOk()
            ->assertSeeLivewire('landing.activity-index');
    }

    public function test_activities_index_displays_only_kegiatan_items()
    {
        // Create a 'kegiatan' gallery
        $activity = Gallery::factory()->create([
            'judul' => 'Kegiatan Pramuka',
            'kategori' => 'kegiatan',
            'deskripsi' => 'Deskripsi kegiatan pramuka',
        ]);
        GalleryPhoto::factory()->create(['gallery_id' => $activity->id]);

        // Create a non-'kegiatan' gallery
        $other = Gallery::factory()->create([
            'judul' => 'Prestasi Siswa',
            'kategori' => 'fasilitas',
            'deskripsi' => 'Deskripsi prestasi siswa',
        ]);
        GalleryPhoto::factory()->create(['gallery_id' => $other->id]);

        Volt::test('landing.activity-index')
            ->assertSee('Kegiatan Pramuka')
            ->assertDontSee('Prestasi Siswa');
    }

    public function test_activities_index_shows_empty_state()
    {
        Volt::test('landing.activity-index')
            ->assertSee('Belum ada kegiatan')
            ->assertSee('Dokumentasi kegiatan belum tersedia saat ini.');
    }
}
