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
        $rombelList = ClassGroup::all();
        
        $mapel = [
            'Senin' => ['08:00 - 10:00' => 'Matematika', '10:15 - 12:00' => 'Bahasa Indonesia'],
            'Selasa' => ['08:00 - 10:00' => 'IPA', '10:15 - 12:00' => 'IPS'],
            'Rabu' => ['08:00 - 10:00' => 'Bahasa Inggris', '10:15 - 12:00' => 'PKN'],
            'Kamis' => ['08:00 - 10:00' => 'Pendidikan Agama', '10:15 - 12:00' => 'Seni Budaya'],
            'Jumat' => ['08:00 - 10:00' => 'Keterampilan Fungsional'],
        ];

        foreach ($rombelList as $rombel) {
            foreach ($mapel as $hari => $jamMapel) {
                foreach ($jamMapel as $jam => $materi) {
                    [$start, $end] = explode(' - ', $jam);
                    
                    Schedule::create([
                        'rombel_id' => $rombel->id,
                        'hari' => $hari,
                        'jam_mulai' => $start,
                        'jam_selesai' => $end,
                        'materi' => $materi,
                    ]);
                }
            }
        }
    }
}
