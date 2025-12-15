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
            $table->longText('latar_belakang')->nullable();
            $table->string('foto_struktur_organisasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkbm_profiles', function (Blueprint $table) {
            $table->dropColumn(['latar_belakang', 'foto_struktur_organisasi']);
        });
    }
};
