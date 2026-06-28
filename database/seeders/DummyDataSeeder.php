<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@roomrental.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // Create Owner Users
        $owners = [];
        for ($i = 1; $i <= 5; $i++) {
            $owners[] = User::updateOrCreate(
                ['email' => "owner{$i}@test.com"],
                [
                    'name' => "Owner {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'owner',
                    'phone' => "+91 98765432{$i}0",
                    'is_verified' => true,
                ]
            );
        }

        // Create Regular Users
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@test.com"],
                [
                    'name' => "User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'phone' => "+91 9876543{$i}00",
                    'is_verified' => true,
                ]
            );
        }

        // Create Sample Rooms
        $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Pune', 'Hyderabad'];
        $roomTypes = ['1BHK', '2BHK', '3BHK', 'Studio', 'PG'];
        
        foreach ($owners as $index => $owner) {
            for ($j = 1; $j <= 3; $j++) {
                $city = $cities[array_rand($cities)];
                $type = $roomTypes[array_rand($roomTypes)];
                $rent = rand(5000, 50000);
                
                Room::create([
                    'user_id' => $owner->id,
                    'title' => "Beautiful {$type} in {$city}",
                    'description' => "Spacious {$type} apartment in prime location. Fully furnished with modern amenities. Close to metro, schools, and shopping malls. Available for immediate possession.",
                    'rent' => $rent,
                    'deposit' => $rent * 2,
                    'city' => $city,
                    'address' => "Street {$j}, Area {$index}, {$city}",
                    'photo' => 'rooms/sample-room.jpg', // You can add actual images later
                    'status' => 'active',
                    'listing_fee_paid' => true,
                    'is_featured' => $j === 1, // First room of each owner is featured
                ]);
            }
        }

        // Create Sample Plans
        $plans = [
            [
                'name' => 'Basic Plan',
                'price' => 499,
                'duration_days' => 30,
                'listing_limit' => 3,
                'type' => 'owner',
                'benefits' => json_encode(['3 room listings', 'Basic support'])
            ],
            [
                'name' => 'Pro Plan',
                'price' => 999,
                'duration_days' => 90,
                'listing_limit' => 10,
                'type' => 'owner',
                'benefits' => json_encode(['10 room listings', 'Priority support', 'Featured badge'])
            ],
            [
                'name' => 'Premium Plan',
                'price' => 1999,
                'duration_days' => 180,
                'listing_limit' => null, // Unlimited
                'type' => 'owner',
                'benefits' => json_encode(['Unlimited listings', '24/7 support', 'Featured badge', 'Top ranking'])
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['name' => $plan['name'], 'type' => $plan['type']],
                $plan
            );
        }

        $this->command->info('Dummy data seeded successfully!');
        $this->command->info('Admin: admin@roomrental.com / password');
        $this->command->info('Owners: owner1@test.com to owner5@test.com / password');
        $this->command->info('Users: user1@test.com to user10@test.com / password');
    }
}

