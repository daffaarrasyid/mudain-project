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
        Schema::table('penjualan_details', function (Blueprint $table) {
            $table->string('tahap_produksi')->default('Belum Diproses');
            $table->integer('progress')->default(0);
            $table->text('catatan_produksi')->nullable();
            $table->foreignId('produksi_updated_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan_details', function (Blueprint $table) {
            //
        });
    }
};
