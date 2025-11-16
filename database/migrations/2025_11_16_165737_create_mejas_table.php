<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja');
            $table->enum('status', ['kosong', 'digunakan', 'reservasi'])->default('kosong');
            $table->foreignId('lokasi_toko_id')->constrained('lokasi_tokos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};

