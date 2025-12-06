<?php

namespace Tests\Feature\Livewire\Landing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Livewire\Volt\Volt;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_gallery_show_page()
    {
        $gallery = Gallery::create([
            'judul' => 'Gallery Test',
            'kategori' => 'kegiatan',
            'deskripsi' => 'Description of gallery test',
            'tanggal' => now(),
            'status' => 'aktif',
        ]);

        $response = $this->get('/galeri/' . $gallery->id);
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.gallery-show');
    }

    public function test_gallery_show_page_displays_data()
    {
        $gallery = Gallery::create([
            'judul' => 'Gallery Test Data',
            'kategori' => 'event',
            'deskripsi' => 'Full description of gallery',
            'tanggal' => now(),
            'status' => 'aktif',
        ]);

        $photo = GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'file_path' => 'path/to/photo.jpg',
            'caption' => 'Photo Caption',
            'urutan' => 1,
        ]);

        $component = Volt::test('landing.gallery-show', ['id' => $gallery->id]);
        
        $component->assertSee('Gallery Test Data');
        $component->assertSee('Full description of gallery');
        $component->assertSee('Event'); // Capitalized category
        $component->assertSee('Photo Caption');
    }

    public function test_gallery_show_page_404_for_invalid_id()
    {
        $response = $this->get('/galeri/invalid-id');
        $response->assertStatus(404);
    }
}
