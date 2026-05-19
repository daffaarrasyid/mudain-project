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
        Schema::table('penjualans', function (Blueprint $table) {
            $table->string('judul_desain')->nullable();
            $table->string('nama_desainer')->nullable();
            $table->string('keterangan_desain')->nullable();
            $table->string('gambar_desain')->nullable(); // Simpan path gambar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            //
        });
    }
};
