<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (NewsCategory::count() === 0) {
            $this->call(NewsCategorySeeder::class);
        }
        if (NewsTag::count() === 0) {
            $this->call(NewsTagSeeder::class);
        }

        $categories = NewsCategory::all();
        $tags = NewsTag::all();

        foreach ($categories as $category) {
            News::factory()->count(3)->create([
                'kategori_id' => $category->id,
            ])->each(function ($news) use ($tags) {
                $news->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
            });
        }
    }
}
