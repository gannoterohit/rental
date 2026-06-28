<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offers = [
            [
                'title' => 'Elegance Redefined: Luxury Living',
                'description' => 'Experience the pinnacle of urban living with our handpicked collection of premium penthouses and luxury suites.',
                'image_path' => 'offers/hero.png',
                'link_url' => route('rooms.index'),
                'placement' => 'home_hero',
                'type' => 'both',
                'target_audience' => 'both',
                'banner_color' => '#0f172a',
                'discount_text' => 'Premium Perks',
                'is_active' => true,
            ],
            [
                'title' => 'Smart Spaces for Modern Professionals',
                'description' => 'Fully managed coliving spaces designed for productivity and community. Book your tour today.',
                'image_path' => 'offers/dashboard_user.png',
                'link_url' => route('rooms.index'),
                'placement' => 'home_hero',
                'type' => 'both',
                'target_audience' => 'both',
                'banner_color' => '#1e1b4b',
                'discount_text' => 'Zero Deposit',
                'is_active' => true,
            ],
            [
                'title' => 'Maximize Your Property Earning',
                'description' => 'List your property with us and reach thousands of verified tenants. Get a free premium boost today.',
                'image_path' => 'offers/owner_promo.png',
                'link_url' => route('plans'),
                'placement' => 'dashboard',
                'type' => 'both',
                'target_audience' => 'owner',
                'banner_color' => '#14532d',
                'discount_text' => 'Owner Perk',
                'is_active' => true,
                'start_date' => Carbon::now(),
            ],
            [
                'title' => 'Unlocked: Exclusive Student Deals',
                'description' => 'Special discounts for students in Indore and Bhopal. Use your student ID to claim.',
                'image_path' => 'offers/dashboard_user.png',
                'link_url' => route('rooms.index'),
                'placement' => 'dashboard',
                'type' => 'both',
                'target_audience' => 'user',
                'banner_color' => '#4c1d95',
                'discount_text' => 'STUDENT25',
                'is_active' => true,
            ],
            [
                'title' => 'Flash Sale: 5 Free Unlocks!',
                'description' => 'Sign up today and get 5 free contact unlocks to jumpstart your room search.',
                'placement' => 'top_nav',
                'type' => 'text_only',
                'discount_text' => 'LIMITED',
                'target_audience' => 'both',
                'banner_color' => '#b91c1c', // Red 700
                'is_active' => true,
            ],
            [
                'title' => 'Featured: Cozy Downtown Studio',
                'description' => 'Mini studio with full amenities. Perfect for solo travelers.',
                'image_path' => 'offers/sidebar_ad.png',
                'link_url' => route('rooms.index'),
                'placement' => 'sidebar',
                'type' => 'both',
                'target_audience' => 'both',
                'banner_color' => '#831843',
                'discount_text' => 'Featured',
                'is_active' => true,
            ],
            [
                'title' => 'Unlock Exclusive Deals!',
                'description' => 'Join our premium membership today and get unlimited contact unlocks, zero brokerage, and priority listings for your dream room.',
                'link_url' => route('plans'),
                'placement' => 'popup',
                'type' => 'text_only',
                'discount_text' => 'LIMITED TIME',
                'target_audience' => 'both',
                'banner_color' => '#6366f1',
                'is_active' => true,
            ],
        ];

        Offer::truncate();
        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}
