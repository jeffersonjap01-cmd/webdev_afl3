<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $admin = User::where('email', 'admin@alvcamatcha.com')->first();
        
        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@alvcamatcha.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            if ($this->command) {
                $this->command->info('Admin user created successfully!');
                $this->command->info('Email: admin@alvcamatcha.com');
                $this->command->info('Password: 12345678');
            }
        } else {
            if ($this->command) {
                $this->command->info('Admin user already exists!');
            }
        }
    }
}
