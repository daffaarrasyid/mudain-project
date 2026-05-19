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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('foto_profil')->nullable(); // Boleh kosong (nanti pake ikon default)
            $table->string('nama_customer');
            $table->string('jabatan')->nullable(); // Cth: Ketua OSIS
            $table->integer('rating')->default(5); // 1 sampai 5
            $table->text('testimoni');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
