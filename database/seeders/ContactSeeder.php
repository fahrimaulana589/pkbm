<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Enums\ContactType; // Assuming enum exists from previous context, otherwise use string

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
            [
                'kategori' => 'Sekretariat Utama',
                'label' => 'PKBM Harapan Bangsa',
                'value' => 'Jl. Pendidikan No. 45, RT 05/RW 02, Mekarsari, Cimahi Tengah, Kota Cimahi, Jawa Barat 40525',
                'type' => 'address',
            ],
            [
                'kategori' => 'Kampus 2',
                'label' => 'Ruang Belajar Vokasi',
                'value' => 'Jl. Karya Bakti No. 10 (Depan Kantor Kelurahan)',
                'type' => 'address',
            ],
            [
                'kategori' => 'Media Sosial',
                'label' => 'Youtube',
                'value' => 'pkbmharapanbangsa_official',
                'type' => 'social',
            ],
            [
                'kategori' => 'Media Sosial',
                'label' => 'Instagram',
                'value' => '@pkbm.harapan.bangsa',
                'type' => 'social',
            ],
             [
                'kategori' => 'Media Sosial',
                'label' => 'Facebook',
                'value' => 'PKBM Harapan Bangsa Cimahi',
                'type' => 'social',
            ],
            [
                'kategori' => 'Kontak',
                'label' => 'Email Resmi',
                'value' => 'info@pkbmharapan.id',
                'type' => 'email',
            ],
            [
                'kategori' => 'Kontak',
                'label' => 'Telepon Kantor',
                'value' => '(022) 6654321',
                'type' => 'phone',
            ],
            [
                'kategori' => 'Kontak',
                'label' => 'Admin PPDB (Whatsapp)',
                'value' => '081234567890',
                'type' => 'whatsapp',
            ],
             [
                'kategori' => 'Kontak',
                'label' => 'Layanan Siswa (Whatsapp)',
                'value' => '081987654321',
                'type' => 'whatsapp',
            ],
            [
                'kategori' => 'Peta Lokasi',
                'label' => 'Google Maps',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.89791851239!2d107.531818!3d-6.8722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e44c6883f32b%3A0x62c9540K82367!2sCimahi!5e0!3m2!1sen!2sid!4v1645498274123',
                'type' => 'iframe',
            ],
        ];

        foreach ($data as $item) {
            Contact::create($item);
        }
    }
}
