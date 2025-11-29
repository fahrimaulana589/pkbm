<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'program_id' => Program::factory(),
            'nomor_sertifikat' => 'PKBM-' . $this->faker->year . '-' . $this->faker->numerify('#####'),
            'tanggal' => $this->faker->date(),
            'file_pdf' => 'certificates/sample.pdf',
        ];
    }
}
