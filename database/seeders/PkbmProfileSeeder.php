<?php

namespace Database\Seeders;

use App\Models\PkbmProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PkbmProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Direktori
        Storage::disk('public')->makeDirectory('pkbm/logo');
        Storage::disk('public')->makeDirectory('pkbm/sambutan');
        Storage::disk('public')->makeDirectory('pkbm/struktur');

        // Generate Dummy Images
        $logoName = 'pkbm/logo/logo-pkbm.jpg';
        $sambutanName = 'pkbm/sambutan/kepala-pkbm.jpg';
        $strukturName = 'pkbm/struktur/struktur-organisasi.jpg';

        $this->createDummyImage($logoName, 'LOGO PKBM', 400, 400);
        $this->createDummyImage($sambutanName, 'FOTO KEPALA', 600, 800);
        $this->createDummyImage($strukturName, 'STRUKTUR ORGANISASI', 1000, 600);

        if (PkbmProfile::count() === 0) {
            PkbmProfile::create([
                'nama_pkbm' => 'PKBM Harapan Bangsa',
                'npsn' => 'P9876543',
                // Address & Location
                'alamat' => 'Jl. Pendidikan No. 45, RT 05/RW 02',
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
                'logo' => $logoName,
                'foto_sambutan' => $sambutanName,
                'kata_sambutan' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nSelamat datang di website resmi PKBM Harapan Bangsa. Kami berkomitmen untuk memberikan layanan pendidikan terbaik bagi seluruh lapisan masyarakat. Pendidikan adalah hak segala bangsa, dan kami hadir untuk memastikan tidak ada yang tertinggal.\n\nMari bergabung bersama kami untuk mewujudkan masa depan yang lebih cerah.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'latar_belakang' => "PKBM Harapan Bangsa berdiri sejak tahun 2010 sebagai respons terhadap kebutuhan masyarakat akan akses pendidikan yang fleksibel namun berkualitas. Dimulai dari satu kelas kecil, kini kami melayani ratusan warga belajar dari berbagai latar belakang.",
                'foto_struktur_organisasi' => $strukturName,
            ]);
        }
    }

    private function createDummyImage($path, $text, $width, $height)
    {
        if (!extension_loaded('gd')) {
            Storage::disk('public')->put($path, '');
            return;
        }

        $image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($image, 240, 240, 240); // Light Grey
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        
        $textColor = imagecolorallocate($image, 0, 50, 100); // Dark Blue
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        
        // Center
        imagestring($image, $fontSize, ($width - $textWidth) / 2, ($height - $textHeight) / 2, $text, $textColor);

        ob_start();
        imagejpeg($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $contents);
    }
}
