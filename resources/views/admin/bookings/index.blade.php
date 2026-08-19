@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3 align-items-end mb-4">

                    {{-- Search --}}
                    <div class="col-lg-4 col-md-6">
                        <label for="search" class="form-label">
                            Search
                        </label>

                        <input type="text" name="search" id="search" class="form-control"
                            value="{{ request('search') }}" placeholder="User name, email or hotel name">
                    </div>

                    {{-- Status --}}
                    <div class="col-lg-2 col-md-6">
                        <label for="status" class="form-label">
                            Booking status
                        </label>

                        <select name="status" id="status" class="form-select">
                            <option value="">All statuses</option>

                            <option value="pending" @selected(request('status') === 'pending')>
                                Pending
                            </option>

                            <option value="confirmed" @selected(request('status') === 'confirmed')>
                                Confirmed
                            </option>

                            <option value="cancelled" @selected(request('status') === 'cancelled')>
                                Cancelled
                            </option>

                            <option value="completed" @selected(request('status') === 'completed')>
                                Completed
                            </option>
                        </select>
                    </div>

                    {{-- Sort field --}}
                    <div class="col-lg-2 col-md-4">
                        <label for="sort" class="form-label">
                            Sort by
                        </label>

                        <select name="sort" id="sort" class="form-select">
                            <option value="created_at" @selected(request('sort', 'created_at') === 'created_at')>
                                Created date
                            </option>

                            <option value="check_in" @selected(request('sort') === 'check_in')>
                                Check In
                            </option>

                            <option value="check_out" @selected(request('sort') === 'check_out')>
                                Check Out
                            </option>
                        </select>
                    </div>

                    {{-- Sort direction --}}
                    <div class="col-lg-2 col-md-4">
                        <label for="direction" class="form-label">
                            Direction
                        </label>

                        <select name="direction" id="direction" class="form-select">
                            <option value="desc" @selected(request('direction', 'desc') === 'desc')>
                                Latest first
                            </option>

                            <option value="asc" @selected(request('direction') === 'asc')>
                                Earliest first
                            </option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-lg-2 col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                Apply
                            </button>

                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                    </div>

                </form>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Bookings</h4>

                        <span class="badge bg-light text-dark">
                            {{ $bookings->total() }} bookings
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Hotel</th>
                                        <th>Room</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Guests</th>
                                        <th>Meal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>#{{ $booking->id }}</strong>
                                            </td>

                                            <td>
                                                <strong>{{ $booking->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $booking->user->email }}
                                                </small>
                                            </td>

                                            <td>{{ $booking->hotel->title }}</td>
                                            <td>{{ $booking->room->type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d.m.Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d.m.Y') }}</td>
                                            <td>{{ $booking->guests }}</td>

                                            <td>
                                                @switch($booking->meal_plan)
                                                    @case('breakfast')
                                                        <span class="badge bg-warning text-dark">Breakfast</span>
                                                    @break

                                                    @case('half_board')
                                                        <span class="badge bg-info text-dark">Half Board</span>
                                                    @break

                                                    @case('all_inclusive')
                                                        <span class="badge bg-success">All Inclusive</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-secondary">No meal</span>
                                                @endswitch
                                            </td>

                                            <td>
                                                <strong>${{ number_format($booking->total_price, 2) }}</strong>
                                            </td>

                                            

                                             @php
                                                $statusClass = match ($booking->status) {
                                                    'confirmed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    'completed' => 'bg-primary',
                                                    'pending' => 'bg-warning text-dark',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp

                                            <td>
                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                                <form action="{{ route('admin.bookings.destroy', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this room?')">
                                                        Delete
                                                    </button>

                                                </form>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center py-5 text-muted">
                                                    No bookings yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </main>
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    @endsection
