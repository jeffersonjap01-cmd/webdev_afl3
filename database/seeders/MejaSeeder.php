<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meja;
use App\Models\LokasiToko;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meja::truncate();

        $lokasiToko = LokasiToko::all();

        if ($lokasiToko->isEmpty()) {
            $this->command->warn('Tidak ada lokasi toko. Jalankan LokasiTokoSeeder terlebih dahulu!');
            return;
        }

        foreach ($lokasiToko as $lokasi) {
            // Setiap lokasi punya 10 meja
            for ($i = 1; $i <= 10; $i++) {
                Meja::create([
                    'nomor_meja' => $i,
                    'status' => 'kosong',
                    'lokasi_toko_id' => $lokasi->id,
                ]);
            }
        }

        $this->command->info('Meja berhasil dibuat untuk semua lokasi!');
    }
}
