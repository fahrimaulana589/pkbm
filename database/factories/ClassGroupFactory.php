<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassGroup>
 */
class ClassGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_id' => Program::factory(),
            'tutor_id' => Tutor::factory(),
            'nama_rombel' => $this->faker->word . ' ' . $this->faker->randomDigit(),
            'periode' => '2024/2025',
        ];
    }
}
