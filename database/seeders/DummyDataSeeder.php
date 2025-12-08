<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure News Categories and Tags exist
        if (NewsCategory::count() === 0) {
            $this->call(NewsCategorySeeder::class);
        }
        if (NewsTag::count() === 0) {
            $this->call(NewsTagSeeder::class);
        }

        $this->command->info('Generating 30 Active Announcements...');
        Announcement::factory(30)->create([
            'status' => 'dipublikasikan',
            'published_at' => now(),
        ]);

        $this->command->info('Generating 30 Active News...');
        // Distribute news across categories
        $categories = NewsCategory::all();
        $tags = NewsTag::all();

        News::factory(30)->create([
            'status' => 'published',
        ])->each(function ($news) use ($categories, $tags) {
            // Assign random category if not already assigned by factory (factory assigns one)
            // Assign random tags
            $news->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        });

        $this->command->info('Generating 30 Active Galleries...');
        Gallery::factory(30)->create([
            'status' => 'aktif',
        ])->each(function ($gallery) {
            GalleryPhoto::factory()->count(rand(5, 10))->create([
                'gallery_id' => $gallery->id,
            ]);
        });

        $this->command->info('Dummy data generation completed.');
    }
}
