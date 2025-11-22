<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing reviews
        Review::truncate();

        // Get all users except admin (admin can't create reviews)
        $users = User::where('role', '!=', 'admin')->get();
        
        // Get all menus
        $menus = Menu::all();

        if ($users->isEmpty() || $menus->isEmpty()) {
            $this->command->warn('Tidak ada user atau menu untuk membuat review. Pastikan UserSeeder dan MenuSeeder sudah dijalankan.');
            return;
        }

        // Sample review comments
        $sampleComments = [
            'Sangat enak! Matcha-nya terasa autentik dan segar. Recommended!',
            'Rasanya oke, tapi harganya agak mahal untuk ukuran porsinya.',
            'Matcha latte favorit saya! Selalu pesan setiap kali ke sini.',
            'Pertama kali coba dan langsung suka. Akan kembali lagi!',
            'Es krim matcha-nya creamy dan tidak terlalu manis. Perfect!',
            'Pelayanannya cepat dan matcha-nya berkualitas tinggi.',
            'Sedikit kecewa karena rasanya kurang kuat untuk matcha premium.',
            'Worth it! Matcha-nya premium dan teksturnya smooth.',
            'Bagus untuk harga segini. Cocok untuk daily drink.',
            'Matcha tradisional yang autentik. Suka dengan aftertaste-nya.',
            'Bisa lebih baik lagi dengan peningkatan kualitas susu.',
            'Overall bagus, tapi harganya bisa lebih kompetitif.',
            'Matcha-nya fresh dan tidak pahit. Perfect untuk pemula.',
            'Salah satu matcha terbaik yang pernah saya coba!',
            'Rasanya standar, tidak ada yang istimewa.',
            'Matcha latte dengan foam yang sempurna. Barista skill-nya bagus!',
            'Es krim matcha-nya unik dan berbeda dari tempat lain.',
            'Cocok untuk yang suka matcha dengan rasa yang kuat.',
            'Pelayanan ramah dan matcha-nya konsisten setiap kali.',
            'Matcha premium dengan harga yang reasonable.',
        ];

        $reviewCount = 0;
        $maxReviews = 25; // More than 10 to demonstrate pagination

        // Create reviews for different user-menu combinations
        foreach ($users as $user) {
            // Shuffle menus to get random combinations
            $shuffledMenus = $menus->shuffle();
            
            // Each user reviews multiple menus (up to all available menus)
            $menusToReview = $shuffledMenus->take(min($menus->count(), rand(4, $menus->count())));
            
            foreach ($menusToReview as $menu) {
                if ($reviewCount >= $maxReviews) {
                    break 2; // Break both loops
                }

                // Random rating (weighted towards positive ratings)
                $rating = $this->getWeightedRating();

                // Random comment (80% chance to have comment)
                $komentar = (rand(1, 10) <= 8) ? $sampleComments[array_rand($sampleComments)] : null;

                Review::create([
                    'user_id' => $user->id,
                    'menu_id' => $menu->id,
                    'rating' => $rating,
                    'komentar' => $komentar,
                    'created_at' => now()->subDays(rand(0, 30)), // Random dates in last 30 days
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);

                $reviewCount++;
            }
        }

        // If we still need more reviews, create additional ones
        if ($reviewCount < $maxReviews) {
            $remaining = $maxReviews - $reviewCount;
            for ($i = 0; $i < $remaining; $i++) {
                $user = $users->random();
                $menu = $menus->random();
                
                // Check if this user already reviewed this menu
                $exists = Review::where('user_id', $user->id)
                    ->where('menu_id', $menu->id)
                    ->exists();
                
                if (!$exists) {
                    $rating = $this->getWeightedRating();
                    $komentar = (rand(1, 10) <= 8) ? $sampleComments[array_rand($sampleComments)] : null;

                    Review::create([
                        'user_id' => $user->id,
                        'menu_id' => $menu->id,
                        'rating' => $rating,
                        'komentar' => $komentar,
                        'created_at' => now()->subDays(rand(0, 30)),
                        'updated_at' => now()->subDays(rand(0, 30)),
                    ]);

                    $reviewCount++;
                }
            }
        }

        $this->command->info("Review seeder berhasil membuat {$reviewCount} review!");
    }

    /**
     * Get weighted rating (more positive ratings)
     */
    private function getWeightedRating(): int
    {
        $weights = [
            5 => 40, // 40% chance for 5 stars
            4 => 30, // 30% chance for 4 stars
            3 => 15, // 15% chance for 3 stars
            2 => 10, // 10% chance for 2 stars
            1 => 5,  // 5% chance for 1 star
        ];

        $total = array_sum($weights);
        $random = rand(1, $total);
        $current = 0;

        foreach ($weights as $rating => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $rating;
            }
        }

        return 5; // Default to 5 stars
    }
}

