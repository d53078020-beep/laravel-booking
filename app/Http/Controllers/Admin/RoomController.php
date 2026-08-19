<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('hotel')->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.rooms.create');

        $hotels = Hotel::orderBy('title')->get();

        return view('admin.rooms.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => ['required', 'numeric'],
            'type' => ['required', 'max:255'],
            'quantity_rooms' => ['required', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'breakfast_price' => ['required', 'numeric', 'min:0'],
            'half_board_price' => ['required', 'numeric', 'min:0'],
            'all_inclusive_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'numeric', 'min:1'],
        ]);

        $validated['image'] = $request->file('image')->store('rooms', 'public');

        $room = Room::query()->create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::query()->findOrFail($id);

        $hotels = Hotel::query()
            ->orderBy('title')
            ->get();

        return view('admin.rooms.edit', compact('room', 'hotels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::query()->findOrFail($id);

        $validated = $request->validate([
            'hotel_id' => ['required', 'exists:hotels,id'],
            'type' => ['required', 'max:255'],
            'quantity_rooms' => ['required', 'numeric', 'min:1'],
            'capacity' => ['required', 'numeric', 'min:1'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
            'breakfast_price' => ['required', 'numeric', 'min:0'],
            'half_board_price' => ['required', 'numeric', 'min:0'],
            'all_inclusive_price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image'],
        ]);

        if ($request->hasFile('image')) {
            // Видаляємо старе фото
            Storage::disk('public')->delete($room->image);

            // Завантажуємо нове
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::query()->findOrFail($id);
        $room->forceDelete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully');
    }
}
