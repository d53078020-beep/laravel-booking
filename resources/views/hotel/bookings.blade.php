@extends('layouts.default')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">My Bookings</h2>
                <p class="text-muted mb-0">Here you can view and manage your booked rooms.</p>
            </div>
        </div>

        @if ($bookings->count())
            <div class="row g-4">
                @foreach ($bookings as $booking)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4">
                            @if ($booking->room?->hotel?->image)
                                <img src="{{ asset('storage/' . $booking->room->hotel->image) }}" class="card-img-top"
                                    style="height:220px; object-fit:cover;" alt="{{ $booking->room->hotel->title }}">
                            @endif

                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-2">
                                    {{ $booking->room->hotel->title ?? 'Unknown hotel' }}
                                </h5>

                                <p class="text-muted mb-3">
                                    {{ $booking->room->type ?? 'Room' }}
                                </p>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Check-in</span>
                                        <strong>{{ $booking->check_in }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Check-out</span>
                                        <strong>{{ $booking->check_out }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Meal plan</span>
                                        <strong>${{ $booking->meal_plan }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Guests</span>
                                        <strong>{{ $booking->guests }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between py-2">
                                        <span class="text-muted">Total price</span>
                                        <strong>${{ $booking->total_price }}</strong>
                                    </div>
                                </div>

                                {{-- Cancel / Cancelled --}}
                                @if ($booking->status === 'cancelled')
                                    <button type="button" class="btn btn-secondary w-100" disabled>
                                        Cancelled
                                    </button>
                                @elseif ($booking->status === 'pending' && $booking->payment_status === 'unpaid')
                                    <form action="{{ route('booking.cancel', $booking) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-outline-danger w-100"
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            Cancel
                                        </button>
                                    </form>
                                @endif


                                {{-- Pay / Paid --}}
                                @if ($booking->status === 'pending' && $booking->payment_status === 'unpaid')
                                    <form action="{{ route('bookings.pay', $booking) }}" method="POST" class="w-100 mt-2">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-success w-100">
                                            Pay
                                        </button>
                                    </form>
                                @elseif ($booking->payment_status === 'paid')
                                    <div class="btn btn-success w-100 disabled">
                                        Paid
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info rounded-4">
                You don't have any bookings yet.
            </div>
        @endif
    </div>
@endsection
