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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // Pengelompokan (Contoh: 'Identitas', 'Alamat', 'Kontak', 'Sosmed')
            $table->string('kategori');

            // Label Data (Contoh: 'Nama PKBM', 'Titik Belajar 1', 'Admin WA 1')
            $table->string('label');

            // Isi Data (Contoh: 'PKBM Cahaya...', 'Jl. P. Komarudin...', '0812...')
            $table->text('value');

            // (Opsional) Tipe data untuk memudahkan view: 'text', 'link', 'map', 'tel'
            $table->string('type')->default('text');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
