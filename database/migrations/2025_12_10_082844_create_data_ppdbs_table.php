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
        Schema::create('data_ppdbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_id')->constrained('ppdbs')->cascadeOnDelete();
            $table->string('nama');
            $table->string('jenis');
            $table->string('status');
            $table->string('default')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ppdbs');
    }
};
