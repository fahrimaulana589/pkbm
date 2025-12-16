<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            AnnouncementSeeder::class,
            TutorSeeder::class,
            ProgramSeeder::class,
            PkbmProfileSeeder::class,
            StudentSeeder::class,
            ClassGroupSeeder::class,
            ScheduleSeeder::class,
            CertificateSeeder::class,
            NewsCategorySeeder::class,
            NewsTagSeeder::class,
            NewsSeeder::class,
            GallerySeeder::class,
            PpdbSeeder::class,
            InfoPpdbSeeder::class,
            DataPpdbSeeder::class,
            PendaftarSeeder::class,
            ContactSeeder::class,
            SettingSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
