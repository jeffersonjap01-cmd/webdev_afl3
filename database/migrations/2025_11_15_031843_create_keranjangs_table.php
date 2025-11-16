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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('lokasi_toko_id')->nullable()->after('menu_id')->constrained('lokasi_tokos')->onDelete('set null');
            // alamat_id column - foreign key constraint will be added in create_alamats_table migration
            $table->unsignedBigInteger('alamat_id')->nullable()->after('lokasi_toko_id');
            $table->integer('qty')->default(1);
            $table->integer('total_harga');
            $table->enum('status_pembayaran', ['Belum Bayar', 'Dibayar'])->default('Belum Bayar')->after('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
