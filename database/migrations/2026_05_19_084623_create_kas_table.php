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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kas')->unique();
            $table->enum('tipe', ['Masuk', 'Keluar']); // In atau Out
            $table->string('jenis'); // Cth: Penjualan, Pembelian, Modal, Operasional
            $table->decimal('nominal', 15, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users'); // Siapa yg input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
