<?php

namespace Tests\Feature\Livewire\Landing;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_news_index_page()
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.news-index');
    }

    public function test_news_index_displays_news_items()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        News::create([
            'judul' => 'Berita Test',
            'slug' => 'berita-test',
            'konten' => 'Konten berita test',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);

        $component = Volt::test('landing.news-index');
        $component->assertSee('Berita Test');
    }

    public function test_news_index_pagination()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        // Create 11 news items
        for ($i = 1; $i <= 11; $i++) {
            News::create([
                'judul' => "Berita $i",
                'slug' => "berita-$i",
                'konten' => "Konten berita $i",
                'status' => 'published',
                'kategori_id' => $category->id,
                'created_at' => now()->subMinutes($i), // Ensure order
            ]);
        }

        $component = Volt::test('landing.news-index');
        
        // Should see the latest 10
        for ($i = 1; $i <= 10; $i++) {
            $component->assertSee("Berita $i");
        }
        
        // Should NOT see the 11th (oldest) on first page
        $component->assertDontSee("Berita 11");
    }

    public function test_can_render_news_detail_page()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        $news = News::create([
            'judul' => 'Berita Detail',
            'slug' => 'berita-detail',
            'konten' => 'Konten detail',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);

        $response = $this->get("/berita/{$news->slug}");
        $response->assertStatus(200);
        $response->assertSeeLivewire('landing.news-show');
        $response->assertSee('Berita Detail');
    }

    public function test_news_detail_sidebar_displays_recent_news()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        
        $currentNews = News::create([
            'judul' => 'Current News',
            'slug' => 'current-news',
            'konten' => 'Content',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);

        $otherNews = News::create([
            'judul' => 'Other News',
            'slug' => 'other-news',
            'konten' => 'Content',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);

        $component = Volt::test('landing.news-show', ['slug' => $currentNews->slug]);
        
        $component->assertSee('Other News'); // Should be in sidebar
        $component->assertSee('Berita Lainnya');
    }
    public function test_landing_news_component_links_to_detail_page()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        $news = News::create([
            'judul' => 'Berita Link Test',
            'slug' => 'berita-link-test',
            'konten' => 'Konten link test',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);

        $component = Volt::test('landing.news');
        
        $component->assertSee("/berita/{$news->slug}");
    }

    public function test_can_filter_news_by_category()
    {
        $category1 = NewsCategory::create(['nama_kategori' => 'Kategori 1', 'slug' => 'kategori-1']);
        $category2 = NewsCategory::create(['nama_kategori' => 'Kategori 2', 'slug' => 'kategori-2']);

        News::create([
            'judul' => 'Berita Kategori 1',
            'slug' => 'berita-kategori-1',
            'konten' => 'Konten 1',
            'status' => 'published',
            'kategori_id' => $category1->id,
        ]);

        News::create([
            'judul' => 'Berita Kategori 2',
            'slug' => 'berita-kategori-2',
            'konten' => 'Konten 2',
            'status' => 'published',
            'kategori_id' => $category2->id,
        ]);

        $component = Volt::test('landing.news-index', ['category' => 'kategori-1']);
        
        $component->assertSee('Berita Kategori 1');
        $component->assertDontSee('Berita Kategori 2');
        $component->assertSee('Kategori: Kategori 1');
    }

    public function test_can_filter_news_by_tag()
    {
        $category = NewsCategory::create(['nama_kategori' => 'Umum', 'slug' => 'umum']);
        $tag1 = \App\Models\NewsTag::create(['nama_tag' => 'Tag 1', 'slug' => 'tag-1']);
        $tag2 = \App\Models\NewsTag::create(['nama_tag' => 'Tag 2', 'slug' => 'tag-2']);

        $news1 = News::create([
            'judul' => 'Berita Tag 1',
            'slug' => 'berita-tag-1',
            'konten' => 'Konten 1',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);
        $news1->tags()->attach($tag1);

        $news2 = News::create([
            'judul' => 'Berita Tag 2',
            'slug' => 'berita-tag-2',
            'konten' => 'Konten 2',
            'status' => 'published',
            'kategori_id' => $category->id,
        ]);
        $news2->tags()->attach($tag2);

        $component = Volt::test('landing.news-index', ['tag' => 'tag-1']);
        
        $component->assertSee('Berita Tag 1');
        $component->assertDontSee('Berita Tag 2');
        $component->assertSee('Tag: Tag 1');
    }
}
