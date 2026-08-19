<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $type = fake()->randomElement([
            'Standard Room',
            'Superior Room',
            'Deluxe Room',
            'Family Room',
            'Junior Suite',
            'Premium Suite',
        ]);

        $unique = fake()->unique()->numberBetween(1000, 999999);

        return [
            'hotel_id' => Hotel::factory(),

            'type' => $type,

            'quantity_rooms' => fake()->numberBetween(1, 10),

            'slug' => Str::slug($type) . '-' . $unique,

            'image' => 'rooms/default-room.jpg',

            'description' => fake()->paragraph(),

            'price' => fake()->randomFloat(2, 50, 400),

            'status' => 'available',

            'breakfast_price' => 15,
            'half_board_price' => 35,
            'all_inclusive_price' => 60,

            'capacity' => fake()->numberBetween(1, 5),
        ];
    }
}