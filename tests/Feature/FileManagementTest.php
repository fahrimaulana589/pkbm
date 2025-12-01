<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\News;
use App\Models\PkbmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class FileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function news_image_is_deleted_when_news_is_deleted()
    {
        $file = UploadedFile::fake()->image('news.jpg');
        $path = $file->store('news', 'public');

        $news = News::factory()->create([
            'gambar' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $news->delete();

        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function old_news_image_is_deleted_when_updated()
    {
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('news', 'public');

        $news = News::factory()->create([
            'gambar' => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg');

        Volt::test('news-form-edit', ['id' => $news->id])
            ->set('gambar', $newFile)
            ->call('save');

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists('news/' . $newFile->hashName());
    }

    /** @test */
    public function announcement_files_are_deleted_when_announcement_is_deleted()
    {
        $thumbnail = UploadedFile::fake()->image('thumb.jpg');
        $attachment = UploadedFile::fake()->create('doc.pdf');
        
        $thumbPath = $thumbnail->store('announcements/thumbnails', 'public');
        $attachPath = $attachment->store('announcements/attachments', 'public');

        $announcement = Announcement::factory()->create([
            'thumbnail' => $thumbPath,
            'lampiran_file' => $attachPath,
        ]);

        Storage::disk('public')->assertExists($thumbPath);
        Storage::disk('public')->assertExists($attachPath);

        $announcement->delete();

        Storage::disk('public')->assertMissing($thumbPath);
        Storage::disk('public')->assertMissing($attachPath);
    }

    /** @test */
    public function old_announcement_files_are_deleted_when_updated()
    {
        $oldThumb = UploadedFile::fake()->image('old_thumb.jpg');
        $oldThumbPath = $oldThumb->store('announcements/thumbnails', 'public');

        $attachment = UploadedFile::fake()->create('doc.pdf');
        $attachPath = $attachment->store('announcements/attachments', 'public');

        $announcement = Announcement::factory()->create([
            'thumbnail' => $oldThumbPath,
            'lampiran_file' => $attachPath,
            'published_at' => now(),
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        $newThumb = UploadedFile::fake()->image('new_thumb.jpg');

        Volt::test('edit-announcement-form', ['id' => $announcement->id])
            ->set('new_thumbnail', $newThumb)
            ->call('save')
            ->assertHasNoErrors();

        Storage::disk('public')->assertMissing($oldThumbPath);
        Storage::disk('public')->assertExists('announcements/thumbnails/' . $newThumb->hashName());
    }

    /** @test */
    public function gallery_photos_files_are_deleted_when_gallery_is_deleted()
    {
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $file->store('gallery/1', 'public');

        $gallery = Gallery::factory()->create();
        $photo = GalleryPhoto::factory()->create([
            'gallery_id' => $gallery->id,
            'file_path' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $gallery->delete();

        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function gallery_photo_file_is_deleted_when_photo_is_deleted_via_form()
    {
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $file->store('gallery/1', 'public');

        $gallery = Gallery::factory()->create();
        $photo = GalleryPhoto::factory()->create([
            'gallery_id' => $gallery->id,
            'file_path' => $path,
        ]);

        Volt::test('gallery-form-edit', ['id' => $gallery->id])
            ->call('deletePhoto', $photo->id);

        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function pkbm_logo_is_deleted_when_profile_is_deleted()
    {
        $file = UploadedFile::fake()->image('logo.jpg');
        $path = $file->store('pkbm/logo', 'public');

        $profile = PkbmProfile::create([
            'nama_pkbm' => 'Test PKBM',
            'npsn' => '12345678',
            'alamat' => 'Jl. Test',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Coblong',
            'desa' => 'Dago',
            'telepon' => '08123456789',
            'email' => 'test@example.com',
            'kepala_pkbm' => 'Test Head',
            'visi' => 'Test Vision',
            'misi' => 'Test Mission',
            'logo' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $profile->delete();

        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function old_pkbm_logo_is_deleted_when_updated()
    {
        $oldFile = UploadedFile::fake()->image('old_logo.jpg');
        $oldPath = $oldFile->store('pkbm/logo', 'public');

        $profile = PkbmProfile::create([
            'nama_pkbm' => 'Test PKBM',
            'npsn' => '12345678',
            'alamat' => 'Jl. Test',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Coblong',
            'desa' => 'Dago',
            'telepon' => '08123456789',
            'email' => 'test@example.com',
            'kepala_pkbm' => 'Test Head',
            'visi' => 'Test Vision',
            'misi' => 'Test Mission',
            'logo' => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image('new_logo.jpg');

        Volt::test('pkbm-profile-form')
            ->set('new_logo', $newFile)
            ->call('save');

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists('pkbm/logo/' . $newFile->hashName());
    }

    /** @test */
    public function news_image_is_deleted_when_model_is_updated_directly()
    {
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('news', 'public');

        $news = News::factory()->create([
            'gambar' => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg');
        $newPath = $newFile->store('news', 'public');

        $news->update(['gambar' => $newPath]);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
    }

    /** @test */
    public function announcement_files_are_deleted_when_model_is_updated_directly()
    {
        $oldThumb = UploadedFile::fake()->image('old_thumb.jpg');
        $oldThumbPath = $oldThumb->store('announcements/thumbnails', 'public');

        $announcement = Announcement::factory()->create([
            'thumbnail' => $oldThumbPath,
        ]);

        $newThumb = UploadedFile::fake()->image('new_thumb.jpg');
        $newThumbPath = $newThumb->store('announcements/thumbnails', 'public');

        $announcement->update(['thumbnail' => $newThumbPath]);

        Storage::disk('public')->assertMissing($oldThumbPath);
        Storage::disk('public')->assertExists($newThumbPath);
    }

    /** @test */
    public function pkbm_logo_is_deleted_when_model_is_updated_directly()
    {
        $oldFile = UploadedFile::fake()->image('old_logo.jpg');
        $oldPath = $oldFile->store('pkbm/logo', 'public');

        $profile = PkbmProfile::create([
            'nama_pkbm' => 'Test PKBM',
            'npsn' => '12345678',
            'alamat' => 'Jl. Test',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Coblong',
            'desa' => 'Dago',
            'telepon' => '08123456789',
            'email' => 'test@example.com',
            'kepala_pkbm' => 'Test Head',
            'visi' => 'Test Vision',
            'misi' => 'Test Mission',
            'logo' => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image('new_logo.jpg');
        $newPath = $newFile->store('pkbm/logo', 'public');

        $profile->update(['logo' => $newPath]);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
    }
    /** @test */
    public function can_remove_temporary_photo_in_gallery_create()
    {
        $photo1 = UploadedFile::fake()->image('photo1.jpg');
        $photo2 = UploadedFile::fake()->image('photo2.jpg');

        Volt::test('gallery-form-create')
            ->set('photos', [$photo1, $photo2])
            ->call('removePhoto', 0)
            ->assertCount('photos', 1);
    }

    /** @test */
    public function old_news_image_is_preserved_when_updated_without_new_image()
    {
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('news', 'public');

        $news = News::factory()->create([
            'gambar' => $oldPath,
        ]);

        Volt::test('news-form-edit', ['id' => $news->id])
            ->set('judul', 'Updated Title')
            ->call('save');

        Storage::disk('public')->assertExists($oldPath);
        $this->assertEquals($oldPath, $news->fresh()->gambar);
    }

    /** @test */
    /** @test */
    public function can_upload_multiple_photos_at_once()
    {
        Storage::fake('public');

        $photos = [];
        for ($i = 0; $i < 7; $i++) {
            $photos[] = UploadedFile::fake()->create("photo_{$i}.jpg", 3000); // 3MB
        }

        Volt::test('gallery-form-create')
            ->set('judul', 'Test Gallery')
            ->set('kategori', 'kegiatan')
            ->set('deskripsi', 'Test Description')
            ->set('tanggal', '2024-01-01')
            ->set('status', 'aktif')
            ->set('newPhotos', $photos) // Simulate upload
            ->call('save') // Call save directly
            ->assertHasNoErrors();
            
        $this->assertEquals(7, GalleryPhoto::count());
    }

    /** @test */
    public function partial_upload_success_with_invalid_files()
    {
        // This test is less relevant now as filtering happens client-side with Alpine.js.
        // However, we can still test server-side validation if someone bypasses client-side.
        
        $validPhoto = UploadedFile::fake()->create('valid.jpg', 6000); // 6MB
        $invalidPhoto = UploadedFile::fake()->create('invalid.jpg', 12000); // 12MB

        Volt::test('gallery-form-create')
            ->set('judul', 'Test Gallery')
            ->set('kategori', 'kegiatan')
            ->set('deskripsi', 'Test Description')
            ->set('tanggal', '2024-01-01')
            ->set('status', 'aktif')
            ->set('newPhotos', [$validPhoto, $invalidPhoto])
            ->call('save')
            ->assertHasErrors(['newPhotos.1']); // Expect error on the second file
    }
}
