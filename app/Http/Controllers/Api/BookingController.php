<?php

namespace App\Http\Controllers\Api;


use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with(['hotel', 'room'])
            ->latest()
            ->paginate(10);

        return BookingResource::collection($bookings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'meal_plan' => ['required', 'in:breakfast,half_board,all_inclusive'],
        ]);

        $room = Room::with('hotel')->findOrFail($request->room_id);

        if ($request->guests > $room->capacity) {
            return response()->json([
                'message' => 'Too many guests for this room.',
            ], 422);
        }

        $hasOverlap = Booking::query()
            ->where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($request) {
                $query
                    ->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->exists();

        if ($hasOverlap) {
            return response()->json([
                'message' => 'This room is already booked for the selected dates.',
            ], 422);
        }

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $nights = $checkIn->diffInDays($checkOut);

        $mealPrice = match ($request->meal_plan) {
            'breakfast' => $room->breakfast_price,
            'half_board' => $room->half_board_price,
            'all_inclusive' => $room->all_inclusive_price,
        };

        $totalPrice = ($room->price + $mealPrice) * $nights;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'hotel_id' => $room->hotel_id,
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'meal_plan' => $request->meal_plan,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $booking->load(['hotel', 'room']);

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You are not allowed to cancel this booking.',
            ], 403);
        }

        if ($booking->payment_status === 'paid') {
            return response()->json([
                'message' => 'Paid booking cannot be cancelled.',
            ], 422);
        }

        if ($booking->status === 'cancelled') {
            return response()->json([
                'message' => 'Booking is already cancelled.',
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        $booking->load(['hotel', 'room']);

        return response()->json([
            'message' => 'Booking cancelled successfully.',
            'booking' => new BookingResource($booking),
        ]);
    }
}
