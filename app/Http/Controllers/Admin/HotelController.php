<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->orderBy('title')->get();
        return view('admin.hotels.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'location' => ['required', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'rate' => ['required', 'numeric', 'min:0', 'max:5'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
        ]);

        $validated['image'] = $request->file('image')->store('hotels', 'public');

        $hotel = Hotel::query()->create($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel added successfully!');
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
        $hotel = Hotel::query()->findOrFail($id);

        $categories = Category::query()->orderBy('title')->get();

        return view('admin.hotels.edit', compact('hotel', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::query()->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'rate' => ['required', 'numeric', 'min:0', 'max:5'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        } else {
            unset($validated['image']);
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::query()->findOrFail($id);
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hotel druged in basket');
    }

    public function basket()
    {
        $hotels = Hotel::onlyTrashed()->paginate();
        return view('admin.hotels.basket', [
            'hotels' => $hotels,
        ]);
    }

    public function restore(string $id)
    {
        $hotel = Hotel::withTrashed()->findOrFail($id);
        $hotel->restore();
        return redirect()->route('admin.hotels.basket')->with('success', 'Hotel restored successfully');
    }

    public function basketRemove(string $id)
    {
        $hotel = Hotel::withTrashed()->findOrFail($id);
        $hotel->forceDelete();
        return redirect()->route('admin.hotels.basket')->with('success', 'Post deleted from basketdde successfully');
    }
}
