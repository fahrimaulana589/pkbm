<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing contacts
        Contact::truncate();

        $data = [
            // Titik Belajar 1 (Address)
            [
                'kategori' => 'Titik Belajar 1',
                'label' => 'PKBM Cahaya Nusantara',
                'value' => 'Jl.P.Komarudin Rt.10/05, Kelurahan Pulo Gebang, Kecamatan Cakung, Kota Jakarta Timur, DKI Jakarta 13950',
                'type' => 'address',
            ],
            // Titik Belajar 2 (Address)
            [
                'kategori' => 'Titik Belajar 2',
                'label' => 'PKBM Cahaya Nusantara',
                'value' => 'Jl. Bekasi Tim. Raya No.150B, RT.8/RW.13, Cipinang Besar Utara, Kecamatan Jatinegara, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13410',
                'type' => 'address',
            ],
            // Sekretariat (Address)
            [
                'kategori' => 'Sekretariat',
                'label' => 'Yayasan Pendidikan Al-Usmaniyah Jakarta',
                'value' => 'Jl. P,Komarudin No.98 Rt.010/05, Kelurahan Pulo Gebang, Kecamatan Cakung, Kota Jakarta Timur, Provinsi DKI Jakarta 13950 Indonesia',
                'type' => 'address',
            ],
            // Social Media & Contacts
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'YOUTUBE',
                'value' => 'pkbmcahayanusantaracakung',
                'type' => 'social',
            ],
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'Facebook',
                'value' => 'pkbmcahayanusantara',
                'type' => 'social',
            ],
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'Email',
                'value' => 'Pkbmcahayanusantara212@gmail.com',
                'type' => 'email',
            ],
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'Phone',
                'value' => '(021) 48705741',
                'type' => 'phone',
            ],
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'Whatsapp 1',
                'value' => '081298545869',
                'type' => 'whatsapp',
            ],
            [
                'kategori' => 'Kontak & Sosial Media',
                'label' => 'Whatsapp 2',
                'value' => '081399459896',
                'type' => 'whatsapp',
            ],
            // Peta (Map) - Specific request to be last
            [
                'kategori' => 'peta', // Lowercase to test sorting logic or uppercase? Let's stick to standardized casing in display.
                'label' => 'Lokasi Utama',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.335378774028!2d106.94537831476906!3d-6.219434995497677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698b64e5250487%3A0x658510523030389f!2sJl.%20P.%20Komarudin%2C%20RT.10%2FRW.5%2C%20Pulo%20Gebang%2C%20Kec.%20Cakung%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2013950!5e0!3m2!1sen!2sid!4v1645498274123!5m2!1sen!2sid',
                'type' => 'iframe',
            ],
        ];

        foreach ($data as $item) {
            Contact::create($item);
        }
    }
}
