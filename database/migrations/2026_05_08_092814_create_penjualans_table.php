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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->foreignId('user_id')->constrained('users'); // Kasir/Operator
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->bigInteger('total_harga');
            $table->bigInteger('bayar');
            $table->bigInteger('kembalian');
            $table->enum('status_pembayaran', ['Lunas', 'Kredit']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
