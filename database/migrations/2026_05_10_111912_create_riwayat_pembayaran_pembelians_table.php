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
        Schema::create('riwayat_pembayaran_pembelians', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel pembelians (Kalau PO dihapus, riwayatnya ikut kehapus)
            $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');

            $table->bigInteger('nominal_bayar'); // Jumlah uang yang ditransfer/dibayar
            $table->date('tanggal_bayar');       // Kapan bayarnya
            $table->string('metode_bayar');      // Cth: Transfer BNI, Tunai, DANA
            $table->text('keterangan')->nullable(); // Cth: "DP Termin 1", "Pelunasan"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembayaran_pembelians');
    }
};
