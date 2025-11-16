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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('nama');
            $table->text('deskripsi');
            $table->decimal('harga', 10, 2)->default(0);
            $table->foreignId('kategori_id')->nullable()->after('harga')->constrained('kategoris')->onDelete('set null');
            $table->integer('stok')->default(0);
            $table->timestamps();

            // Relasi ke tabel lokasi / toko cabang
            $table->foreignId('lokasi_toko_id')->constrained('lokasi_tokos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};