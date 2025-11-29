<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ClassGroup::count() === 0) {
            ClassGroup::factory()->count(3)->create();
        }

        $classGroups = ClassGroup::all();

        foreach ($classGroups as $classGroup) {
            Schedule::factory()->count(3)->create([
                'rombel_id' => $classGroup->id,
            ]);
        }
    }
}
