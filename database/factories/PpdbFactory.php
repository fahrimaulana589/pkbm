<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ppdb>
 */
class PpdbFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'tahun' => $this->faker->numberBetween(2020, 2025),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'start_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
