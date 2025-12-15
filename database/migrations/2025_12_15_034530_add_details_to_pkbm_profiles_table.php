<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pkbm_profiles', function (Blueprint $table) {
            // Identitas Sekolah
            $table->string('jenjang_pendidikan')->nullable();
            $table->string('status_sekolah')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('negara')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();

            // Data Pelengkap
            $table->string('sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            $table->string('status_kepemilikan')->nullable();
            $table->string('sk_izin_operasional')->nullable();
            $table->date('tanggal_sk_izin_operasional')->nullable();
            $table->string('kebutuhan_khusus_dilayani')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('cabang_kcp_unit')->nullable();
            $table->string('rekening_atas_nama')->nullable();
            $table->string('mbs')->nullable();
            $table->boolean('memungut_iuran')->default(false);
            $table->decimal('nominal_iuran', 15, 2)->nullable(); // 15 digits, 2 decimal places
            $table->string('nama_wajib_pajak')->nullable();
            $table->string('npwp')->nullable();

            // Kontak Sekolah
            $table->string('fax')->nullable();
            $table->string('website')->nullable();

            // Data Periodik
            $table->string('waktu_penyelenggaraan')->nullable();
            $table->boolean('bersedia_menerima_bos')->default(true);
            $table->string('akreditasi')->nullable();
            $table->string('sumber_listrik')->nullable();
            $table->integer('daya_listrik')->nullable();
            $table->string('akses_internet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkbm_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'jenjang_pendidikan', 'status_sekolah', 'rt_rw', 'kode_pos', 'negara', 'lintang', 'bujur',
                'sk_pendirian', 'tanggal_sk_pendirian', 'status_kepemilikan', 'sk_izin_operasional', 'tanggal_sk_izin_operasional',
                'kebutuhan_khusus_dilayani', 'nomor_rekening', 'nama_bank', 'cabang_kcp_unit', 'rekening_atas_nama',
                'mbs', 'memungut_iuran', 'nominal_iuran', 'nama_wajib_pajak', 'npwp',
                'fax', 'website',
                'waktu_penyelenggaraan', 'bersedia_menerima_bos', 'akreditasi', 'sumber_listrik', 'daya_listrik', 'akses_internet'
            ]);
        });
    }
};
