<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryPhoto>
 */
class GalleryPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFaker = new \Alirezasedghi\LaravelImageFaker\ImageFaker(new \Alirezasedghi\LaravelImageFaker\Services\LoremFlickr());
        $path = storage_path('app/public/gallery');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $filename = $imageFaker->image($path, 640, 480, false);

        return [
            'gallery_id' => Gallery::factory(),
            'file_path' => 'gallery/' . $filename,
            'caption' => $this->faker->sentence,
            'urutan' => $this->faker->numberBetween(1, 10),
        ];
    }
}
