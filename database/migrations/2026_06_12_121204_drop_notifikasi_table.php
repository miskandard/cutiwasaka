<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('notifikasi');
    }

    public function down(): void
    {
        Schema::create('notifikasi', function ($table) {
            $table->id();
        });
    }
};