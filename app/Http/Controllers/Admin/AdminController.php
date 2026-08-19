<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $hotelsCount = Hotel::count();
        $roomsCount = Room::count();
        $bookingsCount = Booking::count();
        $usersCount = User::count();

        return view('admin.dashboard', compact('hotelsCount', 'roomsCount', 'bookingsCount', 'usersCount'));
    }
}
