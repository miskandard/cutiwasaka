<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {

            $table->id('id_notifikasi');

            $table->unsignedBigInteger('id_user')->nullable();

            $table->string('pesan');

            $table->timestamp('tanggal_notifikasi')
                  ->useCurrent();

            $table->enum('status_baca', [
                'belum',
                'sudah'
            ])->default('belum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};