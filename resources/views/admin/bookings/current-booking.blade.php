@extends('layouts.default')

@section('title', 'Current Booking')

@section('content')
    <div class="container py-5">

        {{-- Page header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Current Booking</h1>
                <p class="text-muted mb-0">
                    Review the details of your active reservation.
                </p>
            </div>

            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                ← Back to bookings
            </a>
        </div>

        <div class="row g-4">

            {{-- Left column --}}
            <div class="col-lg-8">

                {{-- Hotel and room --}}
                <div class="card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="row g-0">

                        <div class="col-md-5">
                            @php
                                $roomImage = is_array($booking->room->images)
                                    ? $booking->room->images[0] ?? null
                                    : $booking->room->images;
                            @endphp

                            @if ($roomImage)
                                <img src="{{ asset('storage/' . $roomImage) }}" alt="{{ $booking->room->title }}"
                                    class="w-100 h-100 object-fit-cover" style="min-height: 280px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100"
                                    style="min-height: 280px;">
                                    <span class="text-muted">No room image</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-7">
                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <div>
                                        <p class="text-uppercase text-muted small fw-semibold mb-1">
                                            {{ $booking->room->hotel->title }}
                                        </p>

                                        <h2 class="h4 fw-bold mb-2">
                                            {{ $booking->room->title }}
                                        </h2>

                                        <p class="text-muted mb-0">
                                            {{ $booking->room->hotel->location ?? $booking->room->hotel->city }}
                                        </p>
                                    </div>

                                    @if ($booking->room->hotel->rate)
                                        <span class="badge bg-primary rounded-pill fs-6">
                                            {{ number_format($booking->room->hotel->rate, 1) }}
                                        </span>
                                    @endif
                                </div>

                                <hr>

                                <p class="text-muted mb-3">
                                    {{ Str::limit($booking->room->description, 180) }}
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        Up to {{ $booking->room->capacity }} guests
                                    </span>

                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        ${{ number_format($booking->room->price, 2) }} / night
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Booking details --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-4">Booking details</h2>

                        <div class="row g-4">

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Check-in</p>

                                    <p class="fw-semibold mb-0">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Check-out</p>

                                    <p class="fw-semibold mb-0">
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Guests</p>

                                    <p class="fw-semibold mb-0">
                                        {{ $booking->guests }}
                                        {{ $booking->guests === 1 ? 'guest' : 'guests' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Nights</p>

                                    <p class="fw-semibold mb-0">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}
                                        nights
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Meal plan</p>

                                    <p class="fw-semibold mb-0">
                                        {{ $booking->meal_plan ? ucwords(str_replace('_', ' ', $booking->meal_plan)) : 'Room only' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <p class="text-muted small mb-1">Booking number</p>

                                    <p class="fw-semibold mb-0">
                                        #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Guest information --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-4">Guest information</h2>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Full name</p>
                                <p class="fw-semibold mb-0">
                                    {{ $booking->user->name }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Email address</p>
                                <p class="fw-semibold mb-0">
                                    {{ $booking->user->email }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            Booking status
                        </label>

                        <select name="status" id="status" class="form-select">
                            <option value="pending" @selected($booking->status === 'pending')>
                                Pending
                            </option>

                            <option value="confirmed" @selected($booking->status === 'confirmed')>
                                Confirmed
                            </option>

                            <option value="cancelled" @selected($booking->status === 'cancelled')>
                                Cancelled
                            </option>

                            <option value="completed" @selected($booking->status === 'completed')>
                                Completed
                            </option>
                        </select>
                    </div>

                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">
                            Update status
                        </button>
                    </div>
                </div>
            </form>

            {{-- Right column --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm sticky-lg-top" style="top: 90px;">

                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-4">Booking summary</h2>

                        @php
                            $nights = \Carbon\Carbon::parse($booking->check_in)->diffInDays(
                                \Carbon\Carbon::parse($booking->check_out),
                            );

                            $roomTotal = $booking->room->price * $nights;
                            $mealTotal = max(0, $booking->total_price - $roomTotal);
                        @endphp

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <p class="mb-0">Room</p>
                                <small class="text-muted">
                                    ${{ number_format($booking->room->price, 2) }}
                                    × {{ $nights }} nights
                                </small>
                            </div>

                            <span class="fw-semibold">
                                ${{ number_format($roomTotal, 2) }}
                            </span>
                        </div>

                        @if ($mealTotal > 0)
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <p class="mb-0">Meal plan</p>
                                    <small class="text-muted">
                                        {{ ucwords(str_replace('_', ' ', $booking->meal_plan)) }}
                                    </small>
                                </div>

                                <span class="fw-semibold">
                                    ${{ number_format($mealTotal, 2) }}
                                </span>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-5">Total</span>

                            <span class="fw-bold fs-4">
                                ${{ number_format($booking->total_price, 2) }}
                            </span>
                        </div>

                        <div class="bg-light rounded-3 p-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Status</span>

                                @switch($booking->status)
                                    @case('confirmed')
                                        <span class="badge bg-success">
                                            Confirmed
                                        </span>
                                    @break

                                    @case('pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    @break

                                    @case('cancelled')
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @break

                                    @case('completed')
                                        <span class="badge bg-primary">
                                            Completed
                                        </span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                @endswitch
                            </div>
                        </div>

                        @if (!in_array($booking->status, ['cancelled', 'completed']))
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-outline-danger w-100">
                                    Cancel booking
                                </button>
                            </form>
                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
