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
            $table->string('foto_sambutan')->nullable()->after('logo');
            $table->text('kata_sambutan')->nullable()->after('foto_sambutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkbm_profiles', function (Blueprint $table) {
            $table->dropColumn(['foto_sambutan', 'kata_sambutan']);
        });
    }
};
