<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoomListingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing rooms
        Room::query()->delete();
        
        // Get all owners
        $owners = User::where('role', 'owner')->get();
        
        if ($owners->isEmpty()) {
            $this->command->error('No owners found! Please create owners first.');
            return;
        }

        $this->command->info('Deleted all existing rooms.');
        $this->command->info('Creating 15 new room listings...');

        // Bhopal Rooms (5)
        $bhopalRooms = [
            [
                'title' => 'Spacious 2BHK Near BHEL Bhopal',
                'description' => 'Beautiful 2BHK apartment with modern amenities in a prime location near BHEL. Perfect for families and working professionals. The apartment features a spacious living room, well-ventilated bedrooms, modular kitchen, and attached bathrooms. Located in a peaceful neighborhood with 24/7 security, power backup, and ample parking space.',
                'room_type' => '2bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply'],
                'rent' => 12000,
                'deposit' => 24000,
                'city' => 'Bhopal',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'BHEL Township, Govindpura, Bhopal',
                'latitude' => 23.2599,
                'longitude' => 77.4126,
                'landmarks' => ['BHEL Gate', 'Govindpura Market', 'City Hospital'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Luxury 3BHK Apartment in Arera Colony',
                'description' => 'Premium 3BHK apartment in the heart of Arera Colony, one of Bhopal\'s most sought-after residential areas. This fully furnished apartment offers a modern lifestyle with high-end fittings, marble flooring, and contemporary interiors. Enjoy amenities like swimming pool, gym, clubhouse, and landscaped gardens.',
                'room_type' => '3bhk',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Gym', 'Swimming Pool', 'Clubhouse'],
                'rent' => 25000,
                'deposit' => 50000,
                'city' => 'Bhopal',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'E-7 Sector, Arera Colony, Bhopal',
                'latitude' => 23.2156,
                'longitude' => 77.4304,
                'landmarks' => ['Arera Club', 'Bittan Market', 'Peoples Mall'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Affordable 1BHK for Students Near MANIT',
                'description' => 'Budget-friendly 1BHK apartment perfect for students and young professionals. Located just 2km from MANIT college, this semi-furnished unit offers a comfortable living space with basic amenities. The area is well-connected with public transport and has plenty of eateries and shops nearby.',
                'room_type' => '1bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'any',
                'amenities' => ['WiFi', 'Parking', 'Water Supply', 'Security'],
                'rent' => 7000,
                'deposit' => 14000,
                'city' => 'Bhopal',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'Link Road Number 3, Near MANIT, Bhopal',
                'latitude' => 23.2156,
                'longitude' => 77.4126,
                'landmarks' => ['MANIT College', 'Chinar Park', 'Bhopal Junction'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=800',
                    'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Modern Studio Apartment in New Market',
                'description' => 'Compact and stylish studio apartment in the bustling New Market area. Perfect for bachelors and working professionals who prefer a minimalist lifestyle. The apartment comes with a kitchenette, attached bathroom, and a balcony. Located close to shopping centers, restaurants, and entertainment hubs.',
                'room_type' => 'flat',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'bachelors',
                'amenities' => ['WiFi', 'Power Backup', 'Water Supply', 'Security'],
                'rent' => 9000,
                'deposit' => 18000,
                'city' => 'Bhopal',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'New Market Area, Zone 1, Bhopal',
                'latitude' => 23.2599,
                'longitude' => 77.4126,
                'landmarks' => ['New Market', 'DB City Mall', 'Hamidia Hospital'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800',
                    'https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Cozy 2BHK with Lake View in Kolar',
                'description' => 'Charming 2BHK apartment offering stunning views of the Upper Lake. This semi-furnished unit is ideal for families who appreciate nature and tranquility. The apartment features a spacious balcony, modern kitchen, and well-lit rooms. The complex has a children\'s play area, jogging track, and 24/7 security.',
                'room_type' => '2bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Garden'],
                'rent' => 14000,
                'deposit' => 28000,
                'city' => 'Bhopal',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'Kolar Road, Near Upper Lake, Bhopal',
                'latitude' => 23.2599,
                'longitude' => 77.4126,
                'landmarks' => ['Upper Lake', 'Van Vihar', 'Boat Club'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
        ];

        // Bangalore Rooms (5)
        $bangaloreRooms = [
            [
                'title' => 'Premium 3BHK in Koramangala',
                'description' => 'Luxurious 3BHK apartment in the heart of Koramangala, Bangalore\'s most vibrant neighborhood. This fully furnished apartment features contemporary design, high-speed internet, and smart home features. Located close to tech parks, shopping malls, and fine dining restaurants. Perfect for IT professionals and expats.',
                'room_type' => '3bhk',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Gym', 'Swimming Pool', 'Clubhouse', 'Play Area'],
                'rent' => 45000,
                'deposit' => 90000,
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'address' => '5th Block, Koramangala, Bangalore',
                'latitude' => 12.9352,
                'longitude' => 77.6245,
                'landmarks' => ['Forum Mall', 'Sony World Junction', 'Jyoti Nivas College'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498f?w=800',
                    'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=800',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600607687644-c7171b42498f?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Spacious 2BHK Near Whitefield Tech Park',
                'description' => 'Well-designed 2BHK apartment located minutes away from major IT parks in Whitefield. This semi-furnished unit offers a perfect work-life balance with modern amenities and excellent connectivity. The apartment complex features a rooftop terrace, gym, and ample parking space.',
                'room_type' => '2bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'bachelors',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Gym'],
                'rent' => 28000,
                'deposit' => 56000,
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'address' => 'ITPL Main Road, Whitefield, Bangalore',
                'latitude' => 12.9698,
                'longitude' => 77.7499,
                'landmarks' => ['ITPL', 'Phoenix Marketcity', 'Whitefield Railway Station'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800',
                    'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Budget-Friendly 1BHK in HSR Layout',
                'description' => 'Affordable 1BHK apartment in HSR Layout, ideal for young professionals and students. This compact unit offers all basic amenities with easy access to public transport, restaurants, and shopping areas. The building has 24/7 security and water supply.',
                'room_type' => '1bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'bachelors',
                'amenities' => ['WiFi', 'Parking', 'Water Supply', 'Security'],
                'rent' => 15000,
                'deposit' => 30000,
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'address' => 'Sector 2, HSR Layout, Bangalore',
                'latitude' => 12.9121,
                'longitude' => 77.6446,
                'landmarks' => ['HSR BDA Complex', '27th Main Road', 'Agara Lake'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=800',
                    'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Elegant Studio in Indiranagar',
                'description' => 'Chic studio apartment in the trendy Indiranagar neighborhood. Perfect for singles who want to be in the center of Bangalore\'s nightlife and culture. The apartment is fully furnished with modern appliances, high-speed WiFi, and a smart TV. Walking distance to cafes, pubs, and shopping streets.',
                'room_type' => 'flat',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'bachelors',
                'amenities' => ['WiFi', 'Power Backup', 'Water Supply', 'Security', 'Lift'],
                'rent' => 18000,
                'deposit' => 36000,
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'address' => '100 Feet Road, Indiranagar, Bangalore',
                'latitude' => 12.9716,
                'longitude' => 77.6412,
                'landmarks' => ['Indiranagar Metro', 'CMH Road', 'Chinnaswamy Stadium'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600566752229-250ed79470e6?w=800',
                    'https://images.unsplash.com/photo-1600573472592-401b489a3cdc?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600566752229-250ed79470e6?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Family-Friendly 4BHK in Jayanagar',
                'description' => 'Spacious 4BHK apartment in the prestigious Jayanagar area, perfect for large families. This semi-furnished unit features large rooms, multiple balconies, and a servant quarter. The building offers excellent amenities including a children\'s play area, community hall, and landscaped gardens. Located in a peaceful residential area with schools and hospitals nearby.',
                'room_type' => 'flat',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Garden', 'Play Area'],
                'rent' => 35000,
                'deposit' => 70000,
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'country' => 'India',
                'address' => '4th Block, Jayanagar, Bangalore',
                'latitude' => 12.9250,
                'longitude' => 77.5838,
                'landmarks' => ['Jayanagar Shopping Complex', 'Ramakrishna Ashram', 'Jayanagar Metro'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600585152915-d208bec867a1?w=800',
                    'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600585152915-d208bec867a1?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
        ];

        // Indore Rooms (5)
        $indoreRooms = [
            [
                'title' => 'Modern 2BHK in Vijay Nagar',
                'description' => 'Contemporary 2BHK apartment in Vijay Nagar, one of Indore\'s most developed areas. This fully furnished unit offers a comfortable living experience with modern amenities. The apartment features a modular kitchen, spacious bedrooms, and a balcony with a city view. Located close to shopping malls, restaurants, and educational institutions.',
                'room_type' => '2bhk',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply'],
                'rent' => 16000,
                'deposit' => 32000,
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'AB Road, Vijay Nagar, Indore',
                'latitude' => 22.7532,
                'longitude' => 75.8937,
                'landmarks' => ['C21 Mall', 'Bombay Hospital', 'Vijay Nagar Square'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=800',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Luxury 3BHK Penthouse in South Tukoganj',
                'description' => 'Exclusive 3BHK penthouse in the upscale South Tukoganj area. This premium property features high ceilings, Italian marble flooring, and designer interiors. Enjoy panoramic city views from the private terrace. The building offers world-class amenities including a swimming pool, gym, spa, and concierge service.',
                'room_type' => '3bhk',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Gym', 'Swimming Pool', 'Clubhouse'],
                'rent' => 30000,
                'deposit' => 60000,
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'MG Road, South Tukoganj, Indore',
                'latitude' => 22.7196,
                'longitude' => 75.8577,
                'landmarks' => ['Treasure Island Mall', 'Sayaji Hotel', 'Rajwada Palace'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800',
                'is_featured' => true,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Student-Friendly 1BHK Near IIT Indore',
                'description' => 'Affordable 1BHK apartment perfect for students and young professionals. Located close to IIT Indore and other educational institutions. This semi-furnished unit offers a comfortable living space with basic amenities. The area has good connectivity and plenty of food joints and shops.',
                'room_type' => '1bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'any',
                'amenities' => ['WiFi', 'Parking', 'Water Supply', 'Security'],
                'rent' => 8000,
                'deposit' => 16000,
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'Simrol Road, Near IIT Indore, Indore',
                'latitude' => 22.6708,
                'longitude' => 75.9068,
                'landmarks' => ['IIT Indore', 'Simrol Village', 'Bypass Road'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800',
                    'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Compact Studio in Palasia',
                'description' => 'Cozy studio apartment in the bustling Palasia area, perfect for bachelors and working professionals. This fully furnished unit includes all modern amenities and is located in the heart of the city. Walking distance to shopping centers, restaurants, and entertainment zones.',
                'room_type' => 'flat',
                'furnishing_type' => 'furnished',
                'tenant_type' => 'bachelors',
                'amenities' => ['WiFi', 'Power Backup', 'Water Supply', 'Security'],
                'rent' => 10000,
                'deposit' => 20000,
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'RNT Marg, Palasia, Indore',
                'latitude' => 22.7244,
                'longitude' => 75.8721,
                'landmarks' => ['Palasia Square', 'Orbit Mall', 'MY Hospital'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800',
                    'https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
            [
                'title' => 'Serene 2BHK in Scheme 78',
                'description' => 'Peaceful 2BHK apartment in the well-planned Scheme 78 area. This semi-furnished unit is ideal for families looking for a quiet neighborhood with all modern conveniences. The apartment features a spacious living area, well-ventilated bedrooms, and a balcony. The complex has a children\'s play area, garden, and 24/7 security.',
                'room_type' => '2bhk',
                'furnishing_type' => 'semi-furnished',
                'tenant_type' => 'family',
                'amenities' => ['WiFi', 'Parking', 'Power Backup', 'Security', 'Lift', 'Water Supply', 'Garden', 'Play Area'],
                'rent' => 13000,
                'deposit' => 26000,
                'city' => 'Indore',
                'state' => 'Madhya Pradesh',
                'country' => 'India',
                'address' => 'Scheme 78, Vijay Nagar, Indore',
                'latitude' => 22.7532,
                'longitude' => 75.8937,
                'landmarks' => ['Scheme 78 Park', 'Brilliant Convention Centre', 'Prestige Institute'],
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'photos' => [
                    'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=800',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800',
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498f?w=800',
                ],
                'photo' => 'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=800',
                'is_featured' => false,
                'listing_fee_paid' => true,
            ],
        ];

        // Combine all rooms
        $allRooms = array_merge($bhopalRooms, $bangaloreRooms, $indoreRooms);

        // Create rooms and assign to owners in round-robin fashion
        $ownerIndex = 0;
        foreach ($allRooms as $roomData) {
            $owner = $owners[$ownerIndex % $owners->count()];
            
            Room::create(array_merge($roomData, [
                'user_id' => $owner->id,
            ]));

            $ownerIndex++;
            $this->command->info("Created: {$roomData['title']} for owner: {$owner->name}");
        }

        $this->command->info("\n✅ Successfully created 15 room listings!");
        $this->command->info("   - 5 rooms in Bhopal");
        $this->command->info("   - 5 rooms in Bangalore");
        $this->command->info("   - 5 rooms in Indore");
    }
}
