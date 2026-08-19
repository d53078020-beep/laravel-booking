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
                            <img src="{{ asset('storage/' . $room->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;" alt="{{ $room->type }}">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $room->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;" alt="{{ $room->type }}">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $room->image) }}" class="d-block w-100"
                                style="height:400px; object-fit:cover;" alt="{{ $room->type }}">
                        </div>

                    </div>

                    {{-- <div class="rounded-4 shadow-sm overflow-hidden">
                        <img src="{{ asset('storage/' . $room->image) }}" class="d-block w-100"
                            style="height:400px; object-fit:cover;" alt="{{ $room->type }}">
                    </div> --}}



                    

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

            <div class="col-lg-6">

                <h1 class="fw-bold mb-3">
                    {{ $room->type }}
                </h1>

                <div>
                    <span>Quantity rooms: <strong>{{ $room->quantity_rooms }}</strong></span>
                </div>

                <p class="mt-2">
                    <span>Capacity: <strong>{{ $room->capacity }}</strong></span>
                </p>

                <p class="mt-4">
                    <span class="fw-bold">
                        From ${{ $room->price }} / night
                    </span>
                </p>

                <div class="d-flex gap-3 mt-4">
                    {{ $room->description }}
                </div>

            </div>

            <form method="post" action="{{ route('booking.store') }}">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <input type="hidden" name="hotel_id" value="{{ $room->hotel->id }}">


                <div class="card p-4 mt-5">
                    <h4>Book this room</h4>

                    <label class="form-label mt-3">Check-in</label>
                    <input type="date" name="check_in" id="checkIn" class="form-control" required>

                    <label class="form-label mt-3">Check-out</label>
                    <input type="date" name="check_out" id="checkOut" class="form-control" required>

                    @if ($bookedDates->isNotEmpty())
                        <div class="alert alert-warning">
                            <h5>Unavailable dates:</h5>

                            <ul class="mb-0">
                                @foreach ($bookedDates as $booking)
                                    <li>
                                        {{ $booking->check_in }} — {{ $booking->check_out }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <label class="form-label mt-3">Meal plan</label>
                    <select name="meal_plan" id="mealPlan" class="form-select">
                        <option value="0">Room only</option>
                        <option value="{{ $room->breakfast_price }}">Breakfast +${{ $room->breakfast_price }}</option>
                        <option value="{{ $room->half_board_price }}">Breakfast + Dinner +${{ $room->half_board_price }}
                        </option>
                        <option value="{{ $room->all_inclusive_price }}">All Inclusive +${{ $room->all_inclusive_price }}
                        </option>
                    </select>

                    <div class="form-label mt-3">
                        <label class="form-label">Guests</label>
                        <input type="number" name="guests" class="form-control" min="1"
                            max="{{ $room->capacity }}" value="1" required>
                    </div>

                    <div class="mt-4">
                        <p>Nights: <span id="nightsCount">0</span></p>
                        <h4>Final price: $<span id="finalPrice">0</span></h4>
                    </div>



                    <input type="submit" value="Book Now" class="btn btn-primary w-100 mt-3">

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif

                </div>

            </form>


            <script>
                const basePrice = Number({{ $room->price }});

                const checkIn = document.getElementById('checkIn');
                const checkOut = document.getElementById('checkOut');
                const mealPlan = document.getElementById('mealPlan');

                const nightsCount = document.getElementById('nightsCount');
                const finalPrice = document.getElementById('finalPrice');

                function calculatePrice() {
                    const checkInDate = new Date(checkIn.value);
                    const checkOutDate = new Date(checkOut.value);

                    const mealPrice = Number(mealPlan.value);

                    if (!checkIn.value || !checkOut.value || checkOutDate <= checkInDate) {
                        nightsCount.textContent = 0;
                        finalPrice.textContent = 0;
                        return;
                    }

                    const diffTime = checkOutDate - checkInDate;
                    const nights = diffTime / (1000 * 60 * 60 * 24);

                    const total = (basePrice + mealPrice) * nights;

                    nightsCount.textContent = nights;
                    finalPrice.textContent = total.toFixed(2);
                }

                checkIn.addEventListener('change', calculatePrice);
                checkOut.addEventListener('change', calculatePrice);
                mealPlan.addEventListener('change', calculatePrice);
            </script>
        @endsection

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
