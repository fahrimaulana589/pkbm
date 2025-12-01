<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence,
            'kategori' => $this->faker->randomElement(['kegiatan', 'fasilitas', 'event']),
            'deskripsi' => $this->faker->paragraph,
            'tanggal' => $this->faker->date(),
            'status' => $this->faker->randomElement(['aktif', 'arsip']),
        ];
    }
}
