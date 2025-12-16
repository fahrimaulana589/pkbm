<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate Header Image for PPDB
        Storage::disk('public')->makeDirectory('settings');
        $imagePath = 'settings/ppdb-header.jpg';
        $this->createDummyImage($imagePath, 'PPDB OPEN REGISTRATION');

        $setting = Setting::first() ?? new Setting();

        $setting->email_server = 'smtp.gmail.com';
        $setting->email_port = '587';
        $setting->email_username = 'admin@pkbmharapan.id';
        $setting->email_password = 'password_rahasia';
        
        $setting->ppdb_foto = $imagePath;
        $setting->ppdb_sambutan = "Selamat Datang di Portal Penerimaan Peserta Didik Baru PKBM Harapan Bangsa.\nSilakan lengkapi data diri dan berkas persyaratan dengan benar.";
        
        $setting->ppdb_alur = json_encode([
            "1. Buat Akun Pendaftaran",
            "2. Isi Formulir Biodata",
            "3. Upload Berkas Persyaratan",
            "4. Verifikasi Admin",
            "5. Pengumuman Kelulusan"
        ]);

        $setting->save();
    }

    private function createDummyImage($path, $text)
    {
        if (!extension_loaded('gd')) {
            Storage::disk('public')->put($path, '');
            return;
        }

        $width = 1200;
        $height = 400;
        $image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($image, 50, 100, 200); // Blue
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $font = 5;
        $textWidth = imagefontwidth($font) * strlen($text);
        imagestring($image, $font, ($width - $textWidth) / 2, $height / 2, $text, $textColor);

        ob_start();
        imagejpeg($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $contents);
    }
}
