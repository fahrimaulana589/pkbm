<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        
        $imageFaker = new \Alirezasedghi\LaravelImageFaker\ImageFaker(new \Alirezasedghi\LaravelImageFaker\Services\LoremFlickr());
        $path = storage_path('app/public/news');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $filename = $imageFaker->image($path, 640, 480, false);

        return [
            'kategori_id' => NewsCategory::factory(),
            'judul' => $title,
            'slug' => Str::slug($title),
            'konten' => $this->faker->paragraphs(3, true),
            'gambar' => 'news/' . $filename,
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
