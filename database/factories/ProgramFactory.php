<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori' => $this->faker->randomElement(['Paket A', 'Paket B', 'Paket C', 'Keaksaraan', 'Kursus', 'Pelatihan', 'Life Skill']),
            'nama_program' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraph(),
            'durasi' => $this->faker->numberBetween(1, 12) . ' Bulan',
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
