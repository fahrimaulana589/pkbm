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
        return [
            'kategori_id' => NewsCategory::factory(),
            'judul' => $title,
            'slug' => Str::slug($title),
            'konten' => $this->faker->paragraphs(3, true),
            'gambar' => 'news/sample.jpg',
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
