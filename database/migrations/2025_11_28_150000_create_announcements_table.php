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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->enum('kategori', ["Umum", "Akademik", "Kesiswaan", "Kepegawaian", "Kegiatan", "Darurat"]);
            $table->enum('prioritas', ["Normal", "Tinggi", "Penting"]);
            $table->enum('status', ["draft", "dipublikasikan", "kadaluarsa", "terjadwal"]);
            $table->string('lampiran_file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('penulis_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};