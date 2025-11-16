<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Relasi ke meja
            $table->foreignId('meja_id')->constrained()->cascadeOnDelete();

            // Status order
            $table->enum('status', ['pending', 'proses', 'paid', 'done'])
                ->default('pending');

            // Waktu aktivitas terakhir (dipakai untuk auto-release)
            $table->timestamp('last_activity_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
