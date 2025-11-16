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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('metode_pembayaran', ['tunai', 'debit', 'kredit', 'e_wallet', 'qris'])->default('tunai');
            $table->decimal('jumlah', 10, 2);
            $table->enum('status', ['pending', 'berhasil', 'gagal', 'dibatalkan'])->default('pending');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->string('bukti_pembayaran')->nullable(); // File path for payment proof
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
