<?php

namespace Tests\Feature;

use App\Models\NewsTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NewsTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_news_tag_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.tag-berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Tag Berita');
    }

    public function test_can_create_news_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Volt::test('news-tag-form-create')
            ->set('nama_tag', 'Workshop')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.tag-berita.index'));

        $this->assertDatabaseHas('news_tags', [
            'nama_tag' => 'Workshop',
            'slug' => 'workshop',
        ]);
    }

    public function test_can_update_news_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = NewsTag::factory()->create();

        Volt::test('news-tag-form-edit', ['id' => $tag->id])
            ->set('nama_tag', 'Updated Tag')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('tag-updated');

        $this->assertDatabaseHas('news_tags', [
            'id' => $tag->id,
            'nama_tag' => 'Updated Tag',
            'slug' => 'updated-tag',
        ]);
    }

    public function test_can_delete_news_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = NewsTag::factory()->create();

        Volt::test('news-tag-table')
            ->call('confirmDelete', $tag->id)
            ->call('delete')
            ->assertDispatched('delete-tag-confirmed');

        $this->assertDatabaseMissing('news_tags', [
            'id' => $tag->id,
        ]);
    }
}
