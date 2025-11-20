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
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->enum('order_type', ['delivery', 'dine_in'])
                ->nullable()
                ->after('status_pembayaran');

            $table->foreignId('meja_id')
                ->nullable()
                ->after('lokasi_toko_id')
                ->constrained('mejas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('meja_id');
            $table->dropColumn('order_type');
        });
    }
};
