<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HomeContoller extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('title')
            ->get();

        $hotels = Hotel::query()
            ->with(['category', 'rooms'])

            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })

            ->when($request->filled('min_price'), function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })

            ->when($request->filled('max_price'), function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })

            ->when($request->filled('guests'), function ($query) use ($request) {
                $query->whereHas('rooms', function ($query) use ($request) {
                    $query->where('capacity', '>=', $request->guests);
                });
            })

            ->when($request->sort === 'price_asc', function ($query) {
                $query->orderBy('price');
            })

            ->when($request->sort === 'price_desc', function ($query) {
                $query->orderByDesc('price');
            })

            ->when($request->sort === 'rating', function ($query) {
                $query->orderByDesc('rate');
            })

            ->when(!$request->filled('sort'), function ($query) {
                $query->latest();
            })

            ->paginate(9)
            ->withQueryString();

        return view('welcome', compact('hotels', 'categories'));
    }


    public function show(string $slug)
    {
        $hotel = Hotel::with('rooms')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('hotel.current-page', compact('hotel'));
    }
}
