<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
    $table->id('id_user');
    $table->string('nama');
    $table->string('username')->unique();
    $table->string('password');
    $table->string('jabatan');
    $table->string('divisi');
    $table->string('alamat')->nullable();
    $table->string('no_hp')->nullable();
    $table->integer('sisa_cuti')->default(12);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
