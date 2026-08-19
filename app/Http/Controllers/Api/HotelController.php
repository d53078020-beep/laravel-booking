<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Resources\HotelResource;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::query()
            ->with('category')
            ->withCount('rooms')
            ->withSum('rooms', 'quantity_rooms')

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
                $query->whereHas('rooms', function ($q) use ($request) {
                    $q->where('capacity', '>=', $request->guests);
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

            ->paginate(10)
            ->withQueryString();

        return HotelResource::collection($hotels);
    }

    public function show(Hotel $hotel)
    {
        $hotel->load([
            'category',
            'rooms',
        ]);
        return new HotelResource($hotel);
    }
}
