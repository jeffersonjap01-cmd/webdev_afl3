<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\LokasiToko;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::truncate();

        $lokasiIds = LokasiToko::pluck('id')->all();

        if (empty($lokasiIds)) {
            $this->command?->warn('Lokasi toko belum tersedia. Jalankan LokasiTokoSeeder terlebih dahulu.');
            return;
        }

        $menus = [
            [
                'gambar' => 'gambar1.jpg',
                'nama' => 'Matcha Latte',
                'deskripsi' => 'Minuman matcha latte yang menyegarkan.',
                'harga' => 35000,
                'stok' => 100,
            ],
            [
                'gambar' => 'gambar2.jpg',
                'nama' => 'Classic Matcha',
                'deskripsi' => 'Teh hijau matcha tradisional Jepang yang kaya antioksidan.',
                'harga' => 25000,
                'stok' => 120,
            ],
            [
                'gambar' => 'gambar3.jpg',
                'nama' => 'Es Krim Matcha',
                'deskripsi' => 'Es krim dengan rasa matcha yang kaya dan lembut.',
                'harga' => 40000,
                'stok' => 80,
            ],
            [
                'gambar' => 'gambar1.jpg',
                'nama' => 'Matcha Frappe',
                'deskripsi' => 'Matcha dengan es blended dan krim lembut.',
                'harga' => 42000,
                'stok' => 90,
            ],
            [
                'gambar' => 'gambar2.jpg',
                'nama' => 'Hojicha Latte',
                'deskripsi' => 'Perpaduan hojicha dan susu segar.',
                'harga' => 38000,
                'stok' => 70,
            ],
        ];

        foreach ($menus as $index => $menuData) {
            Menu::create([
                'gambar' => $menuData['gambar'],
                'nama' => $menuData['nama'],
                'deskripsi' => $menuData['deskripsi'],
                'harga' => $menuData['harga'],
                'stok' => $menuData['stok'],
                'lokasi_toko_id' => $lokasiIds[$index % count($lokasiIds)],
            ]);
        }

        $this->command?->info('Menu default berhasil dibuat!');
    }
}
