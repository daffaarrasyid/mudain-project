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
            $table->foreignId('produk_id')->nullable()->change();

            // Sesuaikan nama tabel 'servis' dengan yang ada di database phpMyAdmin lo. 
            // Kalo misal nama tabelnya 'servises', ganti tulisan 'servis' di bawah ini.
            $table->foreignId('servis_id')->nullable()->constrained('servis')->onDelete('set null');
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
