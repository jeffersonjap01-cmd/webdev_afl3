<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LokasiTokoSeeder::class,
            MejaSeeder::class,
            MenuSeeder::class,
        ]);

        // Optionally create demo customer accounts
        \App\Models\User::factory()->create([
            'name' => 'Sample Customer',
            'email' => 'customer@example.com',
        ]);
    }
}
