<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil Siswa yang ada (yang dibuat dari StudentSeeder)
        $students = Student::all();

        if ($students->isEmpty()) {
            return;
        }

        // Berikan sertifikat hanya ke sebagian siswa (misal yang kelas 12 / lulus)
        foreach ($students->take(5) as $student) {
            Certificate::create([
                'student_id' => $student->id,
                'program_id' => $student->program_id,
                'nomor_sertifikat' => 'DN-02/Pk.C/' . date('Y') . '/' . rand(1000, 9999),
                'tanggal' => now()->subMonths(rand(1, 6)),
                'file_pdf' => 'certificates/' . Str::slug($student->nama_lengkap) . '.pdf',
            ]);
        }
    }
}
