<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Clear existing plans to avoid duplicates during dev
        // Plan::truncate(); 

        // 1. User: Single Unlock (Implicitly handled by fee, but good to have a plan representation if needed, though usually plans are for bundles)
        // Skipping single unlock as it's a pay-per-use feature, not a subscription plan usually.

        // 2. User: 5 Contacts Pack (Quantity Based, Long validity)
        Plan::create([
            'name' => '5 Contacts Pack',
            'price' => 80,
            'duration_days' => 30, // Valid for 30 days
            'contacts_limit' => 5,
            'type' => 'user',
            'benefits' => ['Unlock 5 Owner Contacts', 'Valid for 30 Days', 'Save ₹165 vs Single Unlocks']
        ]);

        // 3. User: Unlimited Week (Time Based, Unlimited Quantity)
        Plan::create([
            'name' => 'Unlimited Week',
            'price' => 299,
            'duration_days' => 7,
            'contacts_limit' => -1, // -1 denotes Unlimited
            'type' => 'user',
            'benefits' => ['Unlimited Contact Unlocks', 'Valid for 7 Days', 'Best for Heavy Searching']
        ]);

        // 4. Owner: 5 Listings Pack
        Plan::create([
            'name' => '5 Listings Pack',
            'price' => 499,
            'duration_days' => 90,
            'listing_limit' => 5,
            'type' => 'owner',
            'benefits' => ['List 5 Rooms', 'Valid for 90 Days', 'Premium Support']
        ]);
        
        // 5. Owner: Unlimited Month
        Plan::create([
             'name' => 'Unlimited Listings Month',
             'price' => 999,
             'duration_days' => 30,
             'listing_limit' => -1,
             'type' => 'owner',
             'benefits' => ['Unlimited Room Listings', 'Valid for 30 Days', 'Featured Badge for 1 Room']
        ]);
    }
}
