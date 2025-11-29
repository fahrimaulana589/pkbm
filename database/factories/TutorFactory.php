<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutor>
 */
class TutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'pendidikan_terakhir' => $this->faker->randomElement(['S1 Pendidikan', 'S2 Pendidikan', 'D3', 'SMA']),
            'keahlian' => $this->faker->jobTitle(),
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
