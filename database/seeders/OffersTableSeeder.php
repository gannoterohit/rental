<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Clean existing offers
        DB::table('offers')->truncate();

        $now = Carbon::now();

        $offers = [
            // 1. TOP NAV STRIP (Subtle, urgency)
            [
                'title' => 'Launch Special: Zero Brokerage on all bookings this week!',
                'description' => 'Limited time offer for new users.',
                'image_path' => null,
                'link_url' => route('rooms.index'),
                'placement' => 'top_nav',
                'type' => 'banner',
                'discount_text' => '0% BROKERAGE',
                'target_audience' => 'both',
                'banner_color' => 'linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%)', // Indigo to Cyan
                'is_active' => true,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(7),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 2. HERO BANNER 1 (Luxurious, Welcome)
            [
                'title' => 'Find Your Perfect Sanctuary',
                'description' => 'Experience premium living with verified owners and secure payments. Get 50% off on your first month service fee.',
                'image_path' => null, // Using CSS gradient fallback for premium look
                'link_url' => route('rooms.index'),
                'placement' => 'home_hero',
                'type' => 'banner',
                'discount_text' => 'PREMIUM WELCOME',
                'target_audience' => 'user',
                'banner_color' => '#1e1b4b', // Dark Indigo
                'is_active' => true,
                'start_date' => $now,
                'end_date' => $now->copy()->addMonth(),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 3. HERO BANNER 2 (Owner specific)
            [
                'title' => 'List Your Property for Free',
                'description' => 'Join thousands of happy owners. Get verified tenants instantly without any listing fees for the first 3 properties.',
                'image_path' => null,
                'link_url' => route('register'), // Assuming register page
                'placement' => 'home_hero',
                'type' => 'banner',
                'discount_text' => 'FREE LISTING',
                'target_audience' => 'owner',
                'banner_color' => '#0f766e', // Teal
                'is_active' => true,
                'start_date' => $now,
                'end_date' => $now->copy()->addMonths(2),
                'created_at' => $now,
                'updated_at' => $now,
            ],

             // 4. MOBILE FEED 1 (App-like, colourful)
            [
                'title' => 'Verified Owners Only',
                'description' => 'We physically verify every owner to ensure your safety and peace of mind.',
                'image_path' => null,
                'link_url' => route('rooms.index', ['verified' => 1]),
                'placement' => 'mobile_feed',
                'type' => 'banner',
                'discount_text' => '100% SECURE',
                'target_audience' => 'both',
                'banner_color' => '#7c3aed', // Violet
                'is_active' => true,
                'start_date' => $now,
                'end_date' => null, // Evergreen
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 5. MOBILE FEED 2 (Discount)
            [
                'title' => 'Student Special Discount',
                'description' => 'Valid ID card holders get extra benefits on security deposits.',
                'image_path' => null,
                'link_url' => route('rooms.index'),
                'placement' => 'mobile_feed',
                'type' => 'banner',
                'discount_text' => 'STUDENT OFFER',
                'target_audience' => 'user',
                'banner_color' => '#db2777', // Pink
                'is_active' => true,
                'start_date' => $now,
                'end_date' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 6. POPUP (Exit Intent / Delay)
            [
                'title' => 'Wait! Unlock Hidden Deals',
                'description' => 'Sign up for our newsletter and get exclusive access to unlisted premium properties in your area.',
                'image_path' => null,
                'link_url' => '#',
                'placement' => 'popup',
                'type' => 'modal',
                'discount_text' => 'EXCLUSIVE ACCESS',
                'target_audience' => 'both',
                'banner_color' => '#000000',
                'is_active' => true,
                'start_date' => $now,
                'end_date' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 7. SIDEBAR (Desktop specific)
            // 7. SIDEBAR (Desktop specific)
            [
                'title' => 'Premium Property Management',
                'description' => 'Let us handle your property while you enjoy the returns. Complete management solution.',
                'image_path' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'link_url' => route('pages.contact'),
                'placement' => 'sidebar',
                'type' => 'banner',
                'discount_text' => 'HASSLE FREE',
                'target_audience' => 'owner',
                'banner_color' => '#ffffff',
                'is_active' => true,
                'start_date' => $now,
                'end_date' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('offers')->insert($offers);
        
        $this->command->info('Offers table seeded successfully with ' . count($offers) . ' premium offers!');
    }
}
