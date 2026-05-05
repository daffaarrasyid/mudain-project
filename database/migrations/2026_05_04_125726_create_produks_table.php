<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->string('kode_barang')->unique();
            $table->string('nama_item');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('cascade');
            // Tambahan relasi Supplier
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->integer('harga_beli');
            // Harga jual dipecah dua
            $table->integer('harga_jual_umum');
            $table->integer('harga_pelanggan');
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
