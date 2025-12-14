<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftar>
 */
class PendaftarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'program_id' => \App\Models\Program::factory(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date(),
            'status' => \App\Enums\PendaftarStatus::TERDAFTAR,
            'code' => fake()->unique()->bothify('REG-#####'),
            'extra_attributes' => [],
        ];
    }
}
