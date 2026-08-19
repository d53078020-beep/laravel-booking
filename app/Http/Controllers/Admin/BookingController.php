<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\IsTrue;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'hotel', 'room']);

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($bookingQuery) use ($search) {

                $bookingQuery->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });

                $bookingQuery->orWhereHas('hotel', function ($hotelQuery) use ($search) {
                    $hotelQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = [
            'created_at',
            'check_in',
            'check_out',
        ];

        $allowedDirections = [
            'asc',
            'desc',
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, $allowedDirections, true)) {
            $direction = 'desc';
        }

        $bookings = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'room.hotel',
            'user',
            'hotel',
        ]);

        return view('admin.bookings.current-booking', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::query()->findOrFail($id);
        $booking->forceDelete();
        return redirect()->back()->with('success', 'Booking deleted!');
    }



    public function cancel(string $id)
    {
        $booking = Booking::query()->findOrFail($id);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,cancelled,completed',
            ],
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['cancelled', 'completed'],
            'cancelled' => [],
            'completed' => []
        ];

        if (!in_array(
            $validated['status'],
            $allowedTransitions[$booking->status] ?? [],
            true
        )) {
            return back()->with('error', 'Invalid status transition');
        }

        Booking::query()
            ->where('status', 'confirmed')
            ->whereDate('check_out', '<', now()->toDateString())
            ->update([
                'status' => 'completed',
            ]);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking status updated successfully.');
    }
}
