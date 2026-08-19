@extends('layouts.default')

@section('content')
    <div class="container py-5">

        <a href="#" class="text-decoration-none text-muted">
            ← Back to hotels
        </a>

        <div class="row mt-4 mb-5">

            <div class="col-lg-6">
                <div id="hotelCarousel" class="carousel slide" data-bs-ride="carousel">

                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="2"></button>
                    </div>

                    <div class="carousel-inner rounded-4 shadow-sm">

                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $hotel->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $hotel->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $hotel->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;">
                        </div>

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>
            </div>

            {{-- IF PHOTOS FROM DB --}}

            {{-- <div class="carousel-inner rounded-4 shadow-sm">
                @foreach ($hotel->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image) }}" class="d-block w-100"
                            style="height:400px; object-fit:cover;">
                    </div>
                @endforeach
            </div> --}}

            {{-- @foreach ($hotels as $hotel) --}}
            <div class="col-lg-6">

                <h1 class="fw-bold mb-3">
                    {{ $hotel->title }}
                </h1>

                <p class="text-muted">
                    {{ $hotel->city }}
                </p>

                <p class="mt-4">
                    {{ $hotel->description }}
                    
                </p>

                <div class="d-flex gap-3 mt-4">
                    <span class="badge bg-dark p-2">
                        ★ {{ $hotel->rate }}
                    </span>

                    <span class="fw-bold">
                        From ${{ $hotel->price }} / night
                    </span>
                </div>

            </div>
            {{-- @endforeach --}}


        </div>

        <h2 class="fw-bold mb-4">
            Available Rooms
        </h2>

        <div class="row g-4">
            @foreach ($hotel->rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('room.show', [
                        'hotel' => $hotel->slug,
                        'room' => $room->slug,
                    ]) }}"
                        class="text-decoration-none text-dark">

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                            <img src="{{ asset('storage/' . $hotel->image) }}" class="card-img-top"
                                style="height:220px; object-fit:cover;">

                            <div class="card-body">

                                <h5 class="fw-bold">
                                    {{ $room->type }}
                                </h5>

                                <div>
                                    <span>Quantity rooms: <strong>{{$room->quantity_rooms}}</strong></span>
                                </div>

                                <p class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($room->description, 100) }}
                                </p>

                                <div class="d-flex justify-content-between">
                                    <strong>${{ $room->price }} / night</strong>
                                    <span class="badge {{ $room->status == 'available' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $room->status }}
                                    </span>
                                </div>

                            </div>

                        </div>

                    </a>
                </div>
            @endforeach

        </div>
    </div>
@endsection
