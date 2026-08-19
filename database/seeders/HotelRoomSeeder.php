<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HotelRoomSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = [];

        foreach (['Hotel', 'Villa', 'Apartment', 'Hostel'] as $title) {
            $categories[$title] = Category::query()->updateOrCreate(
                [
                    'slug' => Str::slug($title),
                ],
                [
                    'title' => $title,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Hotels
        |--------------------------------------------------------------------------
        */

        $hotels = [
            [
                'title' => 'Grand Royal Hotel',
                'location' => 'London, United Kingdom',
                'description' => 'Elegant city hotel with comfortable rooms, modern facilities and a central location close to the main attractions.',
                'price' => 180,
                'rate' => 4.8,
                'category' => 'Hotel',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Blue Coast Resort',
                'location' => 'Heraklion, Greece',
                'description' => 'Modern seaside hotel with beautiful Mediterranean views, comfortable rooms and easy access to the beach.',
                'price' => 150,
                'rate' => 4.7,
                'category' => 'Hotel',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Central Park Hotel',
                'location' => 'New York, USA',
                'description' => 'Comfortable city hotel located close to restaurants, shopping areas and major attractions.',
                'price' => 230,
                'rate' => 4.6,
                'category' => 'Hotel',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Santorini Sunset Villa',
                'location' => 'Santorini, Greece',
                'description' => 'Private Mediterranean villa with panoramic sea views, spacious rooms and a relaxing atmosphere.',
                'price' => 320,
                'rate' => 4.9,
                'category' => 'Villa',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Costa Blanca Villa',
                'location' => 'Alicante, Spain',
                'description' => 'Spacious private villa near the Mediterranean coast, suitable for families and groups.',
                'price' => 280,
                'rate' => 4.8,
                'category' => 'Villa',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Barcelona City Apartments',
                'location' => 'Barcelona, Spain',
                'description' => 'Modern apartments in central Barcelona with comfortable interiors and convenient access to the city.',
                'price' => 130,
                'rate' => 4.5,
                'category' => 'Apartment',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Vienna Residence Apartments',
                'location' => 'Vienna, Austria',
                'description' => 'Stylish apartments offering comfortable accommodation for both short and long stays.',
                'price' => 120,
                'rate' => 4.7,
                'category' => 'Apartment',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Prague Old Town Apartments',
                'location' => 'Prague, Czech Republic',
                'description' => 'Comfortable apartments located near the historic centre with easy access to major landmarks.',
                'price' => 95,
                'rate' => 4.5,
                'category' => 'Apartment',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Amsterdam City Hostel',
                'location' => 'Amsterdam, Netherlands',
                'description' => 'Affordable accommodation for travellers with comfortable rooms and a friendly social atmosphere.',
                'price' => 45,
                'rate' => 4.2,
                'category' => 'Hostel',
                'image' => 'default.jpeg',
            ],

            [
                'title' => 'Berlin Central Hostel',
                'location' => 'Berlin, Germany',
                'description' => 'Modern budget accommodation close to public transport, restaurants and popular city attractions.',
                'price' => 40,
                'rate' => 4.1,
                'category' => 'Hostel',
                'image' => 'default.jpeg',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Create Hotels + Rooms
        |--------------------------------------------------------------------------
        */

        foreach ($hotels as $hotelData) {

            $category = $categories[$hotelData['category']];

            $hotel = Hotel::query()->updateOrCreate(
                [
                    'slug' => Str::slug($hotelData['title']),
                ],
                [
                    'title' => $hotelData['title'],
                    'location' => $hotelData['location'],
                    'description' => $hotelData['description'],
                    'price' => $hotelData['price'],
                    'rate' => $hotelData['rate'],
                    'category_id' => $category->id,
                    'image' => $hotelData['image'],
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Rooms
            |--------------------------------------------------------------------------
            */

            $rooms = [
                [
                    'type' => 'Standard Room',
                    'description' => 'Comfortable standard room with everything needed for a pleasant stay.',
                    'price' => $hotelData['price'],
                    'image' => 'default.jpeg',
                    'capacity' => 2,
                    'status' => 'available',
                    'breakfast_price' => 15,
                    'half_board_price' => 35,
                    'all_inclusive_price' => 60,
                    'quantity_rooms' => 2,
                ],

                [
                    'type' => 'Superior Room',
                    'description' => 'Spacious superior room with upgraded furniture and additional comfort.',
                    'price' => $hotelData['price'] + 30,
                    'image' => 'default.jpeg',
                    'capacity' => 2,
                    'status' => 'available',
                    'breakfast_price' => 15,
                    'half_board_price' => 35,
                    'all_inclusive_price' => 60,
                    'quantity_rooms' => 2,
                ],

                [
                    'type' => 'Deluxe Room',
                    'description' => 'Elegant deluxe room with modern design, additional space and premium amenities.',
                    'price' => $hotelData['price'] + 60,
                    'image' => 'default.jpeg',
                    'capacity' => 3,
                    'status' => 'available',
                    'breakfast_price' => 18,
                    'half_board_price' => 40,
                    'all_inclusive_price' => 70,
                    'quantity_rooms' => 2,
                ],

                [
                    'type' => 'Family Room',
                    'description' => 'Large room designed for families with additional sleeping space and comfortable facilities.',
                    'price' => $hotelData['price'] + 80,
                    'image' => 'default.jpeg',
                    'capacity' => 4,
                    'status' => 'available',
                    'breakfast_price' => 20,
                    'half_board_price' => 45,
                    'all_inclusive_price' => 75,
                    'quantity_rooms' => 2,
                ],

                [
                    'type' => 'Junior Suite',
                    'description' => 'Comfortable junior suite with additional living space and a relaxing seating area.',
                    'price' => $hotelData['price'] + 110,
                    'image' => 'default.jpeg',
                    'capacity' => 3,
                    'status' => 'available',
                    'breakfast_price' => 20,
                    'half_board_price' => 45,
                    'all_inclusive_price' => 80,
                    'quantity_rooms' => 2,
                ],

                [
                    'type' => 'Premium Suite',
                    'description' => 'Premium accommodation with spacious interiors, high-end facilities and maximum comfort.',
                    'price' => $hotelData['price'] + 160,
                    'image' => 'default.jpeg',
                    'capacity' => 4,
                    'status' => 'available',
                    'breakfast_price' => 25,
                    'half_board_price' => 50,
                    'all_inclusive_price' => 90,
                    'quantity_rooms' => 2,
                ],
            ];


            foreach ($rooms as $roomData) {

                $roomSlug = Str::slug(
                    $hotel->title . '-' . $roomData['type']
                );

                $hotel->rooms()->updateOrCreate(
                    [
                        'slug' => $roomSlug,
                    ],
                    [
                        'type' => $roomData['type'],
                        'image' => $roomData['image'],
                        'description' => $roomData['description'],
                        'price' => $roomData['price'],
                        'capacity' => $roomData['capacity'],
                        'quantity_rooms' => $roomData['quantity_rooms'],
                        'status' => $roomData['status'],
                        'breakfast_price' => $roomData['breakfast_price'],
                        'half_board_price' => $roomData['half_board_price'],
                        'all_inclusive_price' => $roomData['all_inclusive_price'],
                    ]
                );
            }
        }
    }
}
