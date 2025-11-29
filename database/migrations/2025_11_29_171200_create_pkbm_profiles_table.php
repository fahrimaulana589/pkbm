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
        Schema::create('pkbm_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pkbm');
            $table->string('npsn')->nullable();
            $table->text('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('kepala_pkbm')->nullable();
            $table->longText('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkbm_profiles');
    }
};
