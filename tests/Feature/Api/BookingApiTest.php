<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'token',
                'user',
            ]);
    }

    public function test_unauthenticated_user_cannot_access_bookings(): void
    {
        $response = $this->getJson('/api/bookings');

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_booking(): void
    {
        $user = User::factory()->create();

        $hotel = Hotel::factory()->create();

        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
            'capacity' => 2,
            'price' => 100,
            'breakfast_price' => 10,
            'half_board_price' => 20,
            'all_inclusive_price' => 30,
        ]);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/bookings', [
                'room_id' => $room->id,
                'check_in' => now()->addDays(10)->toDateString(),
                'check_out' => now()->addDays(15)->toDateString(),
                'guests' => 2,
                'meal_plan' => 'breakfast',
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'status' => 'pending',
        ]);
    }

    public function test_user_cannot_cancel_another_users_booking(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $otherUser->id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->patchJson("/api/bookings/{$booking->id}/cancel");

        $response->assertForbidden();
    }
}