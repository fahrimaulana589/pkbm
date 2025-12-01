<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_gallery_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.galeri.index'));

        $response->assertStatus(200);
        $response->assertSee('Galeri');
    }

    public function test_can_create_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');

        Volt::test('gallery-form-create')
            ->set('judul', 'Kegiatan Baru')
            ->set('kategori', 'kegiatan')
            ->set('deskripsi', 'Deskripsi kegiatan baru.')
            ->set('tanggal', '2024-01-01')
            ->set('status', 'aktif')
            ->set('photos', [$file])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.galeri.index'));

        $this->assertDatabaseHas('galleries', [
            'judul' => 'Kegiatan Baru',
            'kategori' => 'kegiatan',
            'status' => 'aktif',
        ]);

        $gallery = Gallery::where('judul', 'Kegiatan Baru')->first();
        $this->assertCount(1, $gallery->photos);
        Storage::disk('public')->assertExists($gallery->photos->first()->file_path);
    }

    public function test_can_update_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $gallery = Gallery::factory()->create();

        Volt::test('gallery-form-edit', ['id' => $gallery->id])
            ->set('judul', 'Updated Judul')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'judul' => 'Updated Judul',
        ]);
    }

    public function test_can_delete_gallery()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $gallery = Gallery::factory()->create();

        Volt::test('gallery-table')
            ->call('confirmDelete', $gallery->id)
            ->call('delete')
            ->assertDispatched('delete-gallery-confirmed');

        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->id,
        ]);
    }
}
