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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('faktur')->unique(); // PB-20260508-0001
            $table->date('tanggal_faktur');
            $table->foreignId('supplier_id')->constrained('suppliers');
            // TAMBAHAN BARU: Relasi ke Penjualan
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('total_harga');
            $table->bigInteger('diskon')->default(0);
            $table->bigInteger('grand_total');
            $table->bigInteger('bayar');
            $table->bigInteger('sisa_hutang')->default(0);
            $table->date('jatuh_tempo')->nullable();
            $table->enum('status_pembayaran', ['Lunas', 'Hutang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
