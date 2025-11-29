<?php

namespace Tests\Feature\Livewire;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_announcement_with_files()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $attachment = UploadedFile::fake()->create('document.pdf', 1000);

        Volt::test('create-announcement-form')
            ->set('judul', 'Test Announcement')
            ->set('isi', 'Content of the announcement')
            ->set('kategori', 'Umum')
            ->set('prioritas', 'Normal')
            ->set('status', 'draft')
            ->set('start_date', now()->format('Y-m-d'))
            ->set('end_date', now()->addDays(7)->format('Y-m-d'))
            ->set('published_at', now()->format('Y-m-d\TH:i'))
            ->set('thumbnail', $thumbnail)
            ->set('lampiran_file', $attachment)
            ->call('save');

        $this->assertDatabaseHas('announcements', [
            'judul' => 'Test Announcement',
        ]);

        $announcement = Announcement::first();
        Storage::disk('public')->assertExists($announcement->thumbnail);
        Storage::disk('public')->assertExists($announcement->lampiran_file);
    }

    public function test_can_edit_announcement_and_replace_files()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $oldThumbnail = UploadedFile::fake()->image('old_thumbnail.jpg');
        $oldAttachment = UploadedFile::fake()->create('old_document.pdf', 1000);

        $thumbnailPath = $oldThumbnail->store('announcements/thumbnails', 'public');
        $attachmentPath = $oldAttachment->store('announcements/attachments', 'public');

        $announcement = Announcement::create([
            'judul' => 'Old Title',
            'slug' => 'old-title',
            'isi' => 'Old Content',
            'kategori' => 'Umum',
            'prioritas' => 'Normal',
            'status' => 'draft',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'published_at' => now(),
            'thumbnail' => $thumbnailPath,
            'lampiran_file' => $attachmentPath,
            'penulis_id' => $user->id,
        ]);

        $newThumbnail = UploadedFile::fake()->image('new_thumbnail.jpg');
        $newAttachment = UploadedFile::fake()->create('new_document.pdf', 1000);

        Volt::test('edit-announcement-form', ['id' => $announcement->id])
            ->set('judul', 'New Title')
            ->set('new_thumbnail', $newThumbnail)
            ->set('new_lampiran_file', $newAttachment)
            ->call('save');

        $announcement->refresh();

        Storage::disk('public')->assertMissing($thumbnailPath);
        Storage::disk('public')->assertMissing($attachmentPath);
        Storage::disk('public')->assertExists($announcement->thumbnail);
        Storage::disk('public')->assertExists($announcement->lampiran_file);
    }

    public function test_can_edit_announcement_without_changing_files()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $attachment = UploadedFile::fake()->create('document.pdf', 1000);

        $thumbnailPath = $thumbnail->store('announcements/thumbnails', 'public');
        $attachmentPath = $attachment->store('announcements/attachments', 'public');

        $announcement = Announcement::create([
            'judul' => 'Old Title',
            'slug' => 'old-title',
            'isi' => 'Old Content',
            'kategori' => 'Umum',
            'prioritas' => 'Normal',
            'status' => 'draft',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'published_at' => now(),
            'thumbnail' => $thumbnailPath,
            'lampiran_file' => $attachmentPath,
            'penulis_id' => $user->id,
        ]);

        Volt::test('edit-announcement-form', ['id' => $announcement->id])
            ->set('judul', 'New Title')
            ->call('save');

        $announcement->refresh();

        Storage::disk('public')->assertExists($thumbnailPath);
        Storage::disk('public')->assertExists($attachmentPath);
        $this->assertEquals($thumbnailPath, $announcement->thumbnail);
        $this->assertEquals($attachmentPath, $announcement->lampiran_file);
    }

    public function test_files_are_deleted_when_announcement_is_deleted()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        $attachment = UploadedFile::fake()->create('document.pdf', 1000);

        $thumbnailPath = $thumbnail->store('announcements/thumbnails', 'public');
        $attachmentPath = $attachment->store('announcements/attachments', 'public');

        $announcement = Announcement::create([
            'judul' => 'To Delete',
            'slug' => 'to-delete',
            'isi' => 'Content',
            'kategori' => 'Umum',
            'prioritas' => 'Normal',
            'status' => 'draft',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'published_at' => now(),
            'thumbnail' => $thumbnailPath,
            'lampiran_file' => $attachmentPath,
            'penulis_id' => $user->id,
        ]);

        // Trigger delete via the table component
        Volt::test('announcement-table')
            ->set('id', $announcement->id)
            ->call('delete');

        $this->assertDatabaseMissing('announcements', ['id' => $announcement->id]);
        Storage::disk('public')->assertMissing($thumbnailPath);
        Storage::disk('public')->assertMissing($attachmentPath);
    }

    public function test_file_upload_is_required_if_physical_file_is_missing()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Create announcement with file paths in DB, but files do NOT exist in storage
        $announcement = Announcement::create([
            'judul' => 'Missing Files',
            'slug' => 'missing-files',
            'isi' => 'Content',
            'kategori' => 'Umum',
            'prioritas' => 'Normal',
            'status' => 'draft',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'published_at' => now(),
            'thumbnail' => 'announcements/thumbnails/missing.jpg',
            'lampiran_file' => 'announcements/attachments/missing.pdf',
            'penulis_id' => $user->id,
        ]);

        // Try to save without uploading new files - should fail validation
        Volt::test('edit-announcement-form', ['id' => $announcement->id])
            ->set('judul', 'Updated Title')
            ->call('save')
            ->assertHasErrors(['new_thumbnail' => 'required', 'new_lampiran_file' => 'required']);

        // Upload new files - should succeed
        $newThumbnail = UploadedFile::fake()->image('new_thumbnail.jpg');
        $newAttachment = UploadedFile::fake()->create('new_document.pdf', 1000);

        Volt::test('edit-announcement-form', ['id' => $announcement->id])
            ->set('judul', 'Updated Title')
            ->set('new_thumbnail', $newThumbnail)
            ->set('new_lampiran_file', $newAttachment)
            ->call('save')
            ->assertHasNoErrors();

        $announcement->refresh();
        Storage::disk('public')->assertExists($announcement->thumbnail);
        Storage::disk('public')->assertExists($announcement->lampiran_file);
    }
}
