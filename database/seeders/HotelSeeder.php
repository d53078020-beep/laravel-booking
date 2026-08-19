<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::updateOrCreate(
            ['slug' => 'mountain-view-hotel'],
            [
                'title' => 'Mountain View Hotel',
                'city' => 'Bukovel',
                'description' => 'Comfortable hotel near the mountains.',
                'image' => 'https://picsum.photos/600/400?random=1',
                'price' => 1200,
            ]
        );

        Hotel::updateOrCreate(
            ['slug' => 'sea-breeze-resort'],
            [
                'title' => 'Sea Breeze Resort',
                'city' => 'Odessa',
                'description' => 'Modern hotel near the sea.',
                'image' => 'https://picsum.photos/600/400?random=2',
                'price' => 900,
            ]
        );

        Hotel::updateOrCreate(
            ['slug' => 'central-city-hotel'],
            [
                'title' => 'Central City Hotel',
                'slug' => 'central-city-hotel',
                'city' => 'Lviv',
                'description' => 'Minimalist hotel in city center.',
                'image' => 'https://picsum.photos/600/400?random=3',
                'price' => 200,
            ]
        );

        Hotel::updateOrCreate(
            ['slug' => 'forest-spa-complex'],
            [
                'title' => 'Forest SPA Complex',
                'city' => 'Yaremche',
                'description' => 'SPA and relaxation in the forest.',
                'image' => 'https://picsum.photos/600/400?random=4',
                'price' => 700,
            ]
        );
    }
}
