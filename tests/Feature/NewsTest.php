<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_news_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Berita');
    }

    public function test_can_create_news()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = NewsCategory::factory()->create();
        $tag = NewsTag::factory()->create();
        
        Storage::fake('public');
        $file = UploadedFile::fake()->image('news.jpg');

        Volt::test('news-form-create')
            ->set('kategori_id', $category->id)
            ->set('judul', 'Berita Baru')
            ->set('konten', 'Isi berita baru.')
            ->set('status', 'published')
            ->set('gambar', $file)
            ->set('selected_tags', [$tag->id])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.berita.index'));

        $this->assertDatabaseHas('news', [
            'judul' => 'Berita Baru',
            'slug' => 'berita-baru',
            'status' => 'published',
        ]);
        
        $news = News::where('judul', 'Berita Baru')->first();
        $this->assertNotNull($news->gambar);
        Storage::disk('public')->assertExists($news->gambar);
        $this->assertTrue($news->tags->contains($tag->id));
    }

    public function test_can_update_news()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = NewsCategory::factory()->create();
        $news = News::factory()->create(['kategori_id' => $category->id]);

        Volt::test('news-form-edit', ['id' => $news->id])
            ->set('judul', 'Updated Judul')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('news-updated');

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'judul' => 'Updated Judul',
            'slug' => 'updated-judul',
        ]);
    }

    public function test_can_delete_news()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = NewsCategory::factory()->create();
        $news = News::factory()->create(['kategori_id' => $category->id]);

        Volt::test('news-table')
            ->call('confirmDelete', $news->id)
            ->call('delete')
            ->assertDispatched('delete-news-confirmed');

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }
}
