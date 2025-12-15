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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ppdb_foto')->nullable();
            $table->text('ppdb_sambutan')->nullable();
            $table->string('ppdb_alur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('ppdb_foto');
            $table->dropColumn('ppdb_sambutan');
            $table->dropColumn('ppdb_alur');
        });
    }
};
