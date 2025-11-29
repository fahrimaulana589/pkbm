<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Student::count() === 0) {
            Student::factory()->count(5)->create();
        }

        $students = Student::all();

        foreach ($students as $student) {
            Certificate::factory()->create([
                'student_id' => $student->id,
                'program_id' => $student->program_id,
            ]);
        }
    }
}
