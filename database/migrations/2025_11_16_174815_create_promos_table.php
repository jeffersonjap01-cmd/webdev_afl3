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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promo');
            $table->text('deskripsi')->nullable();
            $table->string('kode_promo')->unique();
            $table->decimal('diskon_persen', 5, 2)->default(0); // e.g., 10.00 for 10%
            $table->decimal('diskon_nominal', 10, 2)->nullable(); // Fixed discount amount
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->integer('min_pembelian')->nullable(); // Minimum purchase to use promo
            $table->integer('max_diskon')->nullable(); // Maximum discount amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
