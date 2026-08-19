<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use App\Mail\BookingCreatedMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::with('room')->where('user_id', auth()->id())->get();

        return view('hotel.bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $room = Room::query()->findOrFail($request->room_id);

        $validator = Validator::make($request->all(), [
            'hotel_id' => ['required', 'exists:hotels,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => [
                'required',
                'integer',
                'min:1',
                'max:' . $room->capacity,
            ],
            'meal_plan' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        $hasConflict = Booking::query()
            ->where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $data['check_out'])
            ->where('check_out', '>', $data['check_in'])
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'check_in' => 'This room already booked for taken dates, please try book another date',
                ]);
        }

        $checkIn = \Carbon\Carbon::parse($data['check_in']);
        $checkOut = \Carbon\Carbon::parse($data['check_out']);

        $nights = $checkIn->diffInDays($checkOut);

        $mealPlanPrice = (float) ($data['meal_plan'] ?? 0);

        $data['user_id'] = auth()->id();
        $data['hotel_id'] = $room->hotel_id;
        $data['total_price'] = (
            (float) $room->price + $mealPlanPrice
        ) * $nights;

        $data['user_id'] = auth()->id();
        $data['hotel_id'] = $room->hotel_id;
        $data['total_price'] = (
            (float) $room->price + $mealPlanPrice
        ) * $nights;

        $booking = Booking::query()->create($data);

        $booking->load(['user', 'hotel', 'room']);

        Mail::to($booking->user->email)
            ->send(new BookingCreatedMail($booking));

        return back()->with('success', 'Booking created successfully!');
    }

    public function cancel(string $id)
    {
        $booking = Booking::query()->findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->status = 'cancelled';
        $booking->save();
        return redirect()->back()->with('success', 'Booking cancelled!');
    }
}
