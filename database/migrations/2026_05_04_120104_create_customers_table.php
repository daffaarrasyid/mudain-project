<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_customer')->unique();
            $table->string('nama_customer');
            $table->string('no_telp');
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_customer', ['Umum', 'Pelanggan'])->default('Umum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};