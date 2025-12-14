<?php

namespace Database\Factories;

use App\Enums\DataPpdbType;
use App\Models\DataPpdb;
use App\Models\Ppdb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataPpdb>
 */
class DataPpdbFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataPpdb::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ppdb_id' => Ppdb::factory(),
            'nama' => $this->faker->words(3, true),
            'jenis' => $this->faker->randomElement(DataPpdbType::cases()),
            'status' => $this->faker->randomElement(['active', 'optional', 'inactive']),
            'default' => $this->faker->optional()->sentence(),
        ];
    }
}
