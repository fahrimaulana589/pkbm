<?php

namespace Tests\Feature;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NewsCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_news_category_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.kategori-berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Kategori Berita');
    }

    public function test_can_create_news_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('news-category-form-create')
            ->set('nama_kategori', 'Kegiatan Sekolah')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.kategori-berita.index'));

        $this->assertDatabaseHas('news_categories', [
            'nama_kategori' => 'Kegiatan Sekolah',
            'slug' => 'kegiatan-sekolah',
        ]);
    }

    public function test_can_update_news_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = NewsCategory::factory()->create();

        Volt::test('news-category-form-edit', ['id' => $category->id])
            ->set('nama_kategori', 'Updated Category')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('category-updated');

        $this->assertDatabaseHas('news_categories', [
            'id' => $category->id,
            'nama_kategori' => 'Updated Category',
            'slug' => 'updated-category',
        ]);
    }

    public function test_can_delete_news_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = NewsCategory::factory()->create();

        Volt::test('news-category-table')
            ->call('confirmDelete', $category->id)
            ->call('delete')
            ->assertDispatched('delete-category-confirmed');

        $this->assertDatabaseMissing('news_categories', [
            'id' => $category->id,
        ]);
    }
}
