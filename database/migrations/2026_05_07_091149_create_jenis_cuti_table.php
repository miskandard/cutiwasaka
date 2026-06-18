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
    Schema::create('jenis_cuti', function (Blueprint $table) {
        $table->id('id_jenis_cuti');
        $table->string('nama_jenis_cuti');
        $table->integer('maksimal_hari')->nullable();
        $table->timestamps();
    });
}
};
