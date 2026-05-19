<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->unsignedBigInteger('role_id')->nullable()->after('username');
            $table->string('telepon', 20)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('telepon');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif')->after('alamat');

            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['username', 'role_id', 'telepon', 'alamat', 'status']);
        });
    }
};
