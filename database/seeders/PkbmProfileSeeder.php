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

            $pathSambutan = storage_path('app/public/pkbm/sambutan');
            if (!file_exists($pathSambutan)) {
                mkdir($pathSambutan, 0755, true);
            }
            $filenameSambutan = $imageFaker->image($pathSambutan, 640, 480, false);

            $pathStruktur = storage_path('app/public/pkbm/struktur');
            if (!file_exists($pathStruktur)) {
                mkdir($pathStruktur, 0755, true);
            }
            $filenameStruktur = $imageFaker->image($pathStruktur, 800, 600, false);

            PkbmProfile::create([
                'nama_pkbm' => 'PKBM Harapan Bangsa',
                'npsn' => 'P9876543',
                // Address & Location
                'alamat' => 'Jl. Pendidikan No. 45',
                'rt_rw' => '05/02',
                'desa' => 'Mekarsari',
                'kecamatan' => 'Cimahi Tengah',
                'kota' => 'Cimahi',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40525',
                'negara' => 'Indonesia',
                'lintang' => '-6.8722',
                'bujur' => '107.5422',
                
                // Contacts
                'telepon' => '022-6654321',
                'fax' => '022-6654322',
                'email' => 'info@pkbmharapan.id',
                'website' => 'https://pkbmharapan.id',
                
                // Identity
                'jenjang_pendidikan' => 'Paket A, B, C',
                'status_sekolah' => 'Swasta',
                'akreditasi' => 'B',
                'kepala_pkbm' => 'Drs. Budi Santoso, M.Pd.',
                
                // Legal & Periodic
                'sk_pendirian' => '421.9/SK-123/DISDIK/2010',
                'tanggal_sk_pendirian' => '2010-05-15',
                'sk_izin_operasional' => '421.9/IO-456/DPMPTSP/2020',
                'tanggal_sk_izin_operasional' => '2020-06-20',
                'status_kepemilikan' => 'Yayasan',
                'kebutuhan_khusus_dilayani' => 'Tidak Ada',
                'nomor_rekening' => '123-456-7890',
                'nama_bank' => 'Bank BJB',
                'cabang_kcp_unit' => 'Cabang Cimahi',
                'rekening_atas_nama' => 'PKBM Harapan Bangsa',
                'mbs' => 'Ya',
                'memungut_iuran' => true,
                'nominal_iuran' => 50000,
                'nama_wajib_pajak' => 'Yayasan Pendidikan Harapan',
                'npwp' => '12.345.678.9-421.000',
                
                // Periodic Data
                'waktu_penyelenggaraan' => 'Sepanjang Hari (Pagi-Sore)',
                'bersedia_menerima_bos' => true,
                'sumber_listrik' => 'PLN',
                'daya_listrik' => '2200',
                'akses_internet' => 'Indihome Fiber',
                
                // Content
                'visi' => 'Terwujudnya masyarakat pembelajar yang cerdas, terampil, dan berakhlak mulia.',
                'misi' => "1. Menyelenggarakan pendidikan kesetaraan yang bermutu.\n2. Mengembangkan keterampilan vokasional sesuai kebutuhan pasar kerja.\n3. Menanamkan nilai-nilai karakter dan budi pekerti luhur.",
                'logo' => 'pkbm/logo/' . $filename,
                'foto_sambutan' => 'pkbm/sambutan/' . $filenameSambutan,
                'kata_sambutan' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di website resmi PKBM Harapan Bangsa. Kami hadir sebagai solusi pendidikan alternatif yang berkualitas bagi masyarakat.\n\nMelalui berbagai program pendidikan kesetaraan dan pelatihan keterampilan, kami berkomitmen untuk mencetak generasi yang kompeten dan mandiri. Mari bergabung bersama kami untuk meraih masa depan yang gemilang.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'latar_belakang' => "PKBM Harapan Bangsa didirikan pada tahun 2010 atas inisiatif tokoh masyarakat setempat yang peduli akan pendidikan. Berawal dari kegiatan belajar mengajar sederhana di garasi rumah, kini kami telah berkembang memiliki gedung sendiri yang representatif.\n\nPerjalanan panjang kami diwarnai dengan berbagai prestasi dan pengakuan dari pemerintah maupun masyarakat. Kami terus berinovasi untuk memberikan layanan pendidikan terbaik yang relevan dengan perkembangan zaman.",
                'foto_struktur_organisasi' => 'pkbm/struktur/' . $filenameStruktur,
            ]);
        }
    }
}
