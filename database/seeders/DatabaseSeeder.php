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

        // Create demo customer accounts for reviews
        \App\Models\User::factory()->create([
            'name' => 'Sample Customer',
            'email' => 'customer@example.com',
        ]);

        // Create additional customers for more diverse reviews
        \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sari Indah',
            'email' => 'sari@example.com',
        ]);

        // Seed reviews after users and menus are created
        $this->call([
            ReviewSeeder::class,
        ]);
    }
}
