@extends('layouts.default')


@section('content')
    <div class="container py-5">

        <h2 class="fw-bold mb-4">Hotels</h2>

        <div>
            <form action="{{ route('home') }}" method="GET" class="row g-3 mb-4">

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Category</label>

                    <select name="category" class="form-select">
                        <option value="">All categories</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Min price</label>

                    <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}"
                        placeholder="$0">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Max price</label>

                    <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}"
                        placeholder="$1000">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Guests</label>

                    <select name="guests" class="form-select">
                        <option value="">Any</option>
                        <option value="1" @selected(request('guests') == 1)>1 guest</option>
                        <option value="2" @selected(request('guests') == 2)>2 guests</option>
                        <option value="3" @selected(request('guests') == 3)>3 guests</option>
                        <option value="4" @selected(request('guests') == 4)>4+ guests</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Sort</label>

                    <select name="sort" class="form-select">
                        <option value="">Newest</option>

                        <option value="price_asc" @selected(request('sort') === 'price_asc')>
                            Price: low to high
                        </option>

                        <option value="price_desc" @selected(request('sort') === 'price_desc')>
                            Price: high to low
                        </option>

                        <option value="rating" @selected(request('sort') === 'rating')>
                            Highest rating
                        </option>
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">
                        Apply filters
                    </button>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <div class="row g-4">


            @foreach ($hotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('hotel', ['slug' => $hotel->slug]) }}" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                            <img src="{{ asset('storage/' . $hotel->image) }}" class="card-img-top"
                                style="height: 220px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="fw-bold">{{ $hotel->title }}</h5>
                                <p class="text-muted mb-2">{{ $hotel->location }}</p>
                                <p class="text-muted small">{{ $hotel->description }}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>From: ${{ $hotel->price }} / night</strong>
                                    <span class="badge bg-dark">{{ $hotel->rate }} ★</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
