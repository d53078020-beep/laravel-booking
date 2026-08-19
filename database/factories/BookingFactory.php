<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'hotel_id' => Hotel::factory(),

            'room_id' => Room::factory(),

            'check_in' => now()->addDays(10)->toDateString(),

            'check_out' => now()->addDays(15)->toDateString(),

            'guests' => 2,

            'meal_plan' => 'breakfast',

            'total_price' => 500,

            'status' => 'pending',

            'payment_status' => 'unpaid',

            'paid_at' => null,
        ];
    }
}