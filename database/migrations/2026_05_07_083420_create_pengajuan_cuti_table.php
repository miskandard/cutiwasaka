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
    Schema::create('pengajuan_cuti', function (Blueprint $table) {

        $table->id('id_pengajuan');

        $table->unsignedBigInteger('id_user');

        $table->date('tanggal_pengajuan');

        $table->date('tanggal_mulai');

        $table->date('tanggal_selesai');

        $table->integer('jumlah_hari');

        $table->text('alasan_pengajuan');

        $table->enum('status_pengajuan', [
            'menunggu',
            'disetujui',
            'ditolak'
        ])->default('menunggu');

        $table->timestamps();

    });
}
};
