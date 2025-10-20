<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::truncate();
         
        Menu::create([
            'gambar' => 'gambar1.jpg',
            'nama' => 'Matcha Latte',
            'deskripsi' => 'Minuman matcha latte yang menyegarkan.',
        ]);
        Menu::create([
            'gambar' => 'gambar2.jpg',
            'nama' => 'Matcha',
            'deskripsi' => 'Teh hijau matcha tradisional Jepang yang kaya antioksidan.',
        ]);
        Menu::create([
            'gambar' => 'gambar3.jpg',
            'nama' => 'Es Krim Matcha',
            'deskripsi' => 'Es krim dengan rasa matcha yang kaya dan lembut.',
        ]);
    }
}
