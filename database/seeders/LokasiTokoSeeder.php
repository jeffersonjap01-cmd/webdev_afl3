<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LokasiToko;

class LokasiTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LokasiToko::truncate();

        LokasiToko::create([
            'nama_lokasi' => 'Alvca Matcha - Jakarta Selatan',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190',
            'no_telepon' => '+62 21 1234 5678',
        ]);

        LokasiToko::create([
            'nama_lokasi' => 'Alvca Matcha - Bandung',
            'alamat' => 'Jl. Dago No. 45, Bandung, Jawa Barat 40135',
            'no_telepon' => '+62 22 8765 4321',
        ]);

        LokasiToko::create([
            'nama_lokasi' => 'Alvca Matcha - Surabaya',
            'alamat' => 'Jl. Tunjungan No. 78, Surabaya, Jawa Timur 60275',
            'no_telepon' => '+62 31 2345 6789',
        ]);

        $this->command->info('Lokasi toko berhasil dibuat!');
    }
}
