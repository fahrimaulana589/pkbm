<?php

namespace Database\Seeders;

use App\Models\PkbmProfile;
use Illuminate\Database\Seeder;

class PkbmProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (PkbmProfile::count() === 0) {
            $imageFaker = new \Alirezasedghi\LaravelImageFaker\ImageFaker(new \Alirezasedghi\LaravelImageFaker\Services\LoremFlickr());
            $path = storage_path('app/public/pkbm/logo');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $filename = $imageFaker->image($path, 640, 480, false);

            PkbmProfile::create([
                'nama_pkbm' => 'PKBM Harapan Bangsa',
                'npsn' => '12345678',
                'alamat' => 'Jl. Merdeka No. 12',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Cicendo',
                'desa' => 'Sukamulya',
                'telepon' => '08123456789',
                'email' => 'info@pkbmharapan.id',
                'kepala_pkbm' => 'Drs. Rudi Hartono',
                'visi' => 'Menjadi lembaga pendidikan masyarakat unggul...',
                'misi' => '- Memberikan layanan pendidikan...',
                'logo' => 'pkbm/logo/' . $filename,
            ]);
        }
    }
}
