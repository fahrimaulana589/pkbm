<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\Program;
use App\Models\Tutor;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are programs and tutors to attach class groups to
        if (Program::count() === 0) {
            Program::factory()->count(3)->create();
        }
        if (Tutor::count() === 0) {
            Tutor::factory()->count(3)->create();
        }

        $programs = Program::all();
        $tutors = Tutor::all();

        foreach ($programs as $program) {
            ClassGroup::factory()->count(2)->create([
                'program_id' => $program->id,
                'tutor_id' => $tutors->random()->id,
            ]);
        }
    }
}
