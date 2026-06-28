<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class SubscriptionPlansSeeder extends Seeder
{
    public function run(): void
    {
        // Contact Subscription Plans (ONLY for users)
        Plan::updateOrCreate(
            ['name' => '5 Contacts Plan'],
            [
                'name' => '5 Contacts Plan',
                'price' => 199,
                'duration_days' => 30,
                'listing_limit' => 0,
                'contacts_limit' => 5,
                'type' => 'user',
                'benefits' => [
                    'Unlock 5 room contacts',
                    'Lifetime validity',
                    'Count-based, use anytime',
                    'Save on individual unlocks'
                ]
            ]
        );

        Plan::updateOrCreate(
            ['name' => '10 Contacts Plan'],
            [
                'name' => '10 Contacts Plan',
                'price' => 349,
                'duration_days' => 30,
                'listing_limit' => 0,
                'contacts_limit' => 10,
                'type' => 'user',
                'benefits' => [
                    'Unlock 10 room contacts',
                    'Lifetime validity',
                    'Count-based, use anytime',
                    'Best value for money'
                ]
            ]
        );

        // Room Listing Plans (ONLY for owners)
        Plan::updateOrCreate(
            ['name' => '3 Rooms Listing Plan'],
            [
                'name' => '3 Rooms Listing Plan',
                'price' => 499,
                'duration_days' => 30,
                'listing_limit' => 3,
                'contacts_limit' => 0,
                'type' => 'owner',
                'benefits' => [
                    'List 3 rooms or make available',
                    'Lifetime validity',
                    'Count-based, use anytime',
                    'Save on individual listings'
                ]
            ]
        );

        Plan::updateOrCreate(
            ['name' => '5 Rooms Listing Plan'],
            [
                'name' => '5 Rooms Listing Plan',
                'price' => 799,
                'duration_days' => 30,
                'listing_limit' => 5,
                'contacts_limit' => 0,
                'type' => 'owner',
                'benefits' => [
                    'List 5 rooms or make available',
                    'Lifetime validity',
                    'Count-based, use anytime',
                    'Best value for money'
                ]
            ]
        );

        Plan::updateOrCreate(
            ['name' => '10 Rooms Listing Plan'],
            [
                'name' => '10 Rooms Listing Plan',
                'price' => 1499,
                'duration_days' => 30,
                'listing_limit' => 10,
                'contacts_limit' => 0,
                'type' => 'owner',
                'benefits' => [
                    'List 10 rooms or make available',
                    'Lifetime validity',
                    'Count-based, use anytime',
                    'Maximum savings'
                ]
            ]
        );
    }
}
