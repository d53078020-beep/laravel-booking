<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;

class RoomContoller extends Controller
{

    public function index(Hotel $hotel, Room $room)
    {

    $bookedDates = $room->bookings()
        ->whereIn('status', ['pending', 'confirmed'])
        ->get(['check_in', 'check_out']);

        return view('hotel.current-room-page', compact('hotel', 'room', 'bookedDates'));
    }
}
