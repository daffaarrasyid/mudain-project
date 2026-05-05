<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel produk
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->enum('jenis', ['Masuk', 'Keluar']);
            $table->integer('jumlah');
            $table->bigInteger('nilai'); // Akan diisi otomatis (Harga Beli * Jumlah)
            $table->dateTime('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};