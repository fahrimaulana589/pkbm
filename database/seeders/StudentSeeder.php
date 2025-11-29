<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are programs to attach students to
        if (Program::count() === 0) {
            Program::factory()->count(5)->create();
        }

        $programs = Program::all();

        foreach ($programs as $program) {
            Student::factory()->count(5)->create([
                'program_id' => $program->id,
            ]);
        }
    }
}
