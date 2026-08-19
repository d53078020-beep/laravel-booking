@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            @include('layouts.admin-panel')

            {{-- Main content --}}
            <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Dashboard</h2>
                    <span class="text-muted">Welcome, {{ auth()->user()->name }}</span>
                </div>

                {{-- Statistic cards --}}
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Hotels</h6>
                                    <h3 class="mb-0">{{ $hotelsCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Rooms</h6>
                                <h3 class="mb-0">{{ $roomsCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Bookings</h6>
                                <h3 class="mb-0">{{ $bookingsCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Users</h6>
                                <h3 class="mb-0">{{ $usersCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick actions --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-primary">Add Hotel</a>
                            <a href="#" class="btn btn-success">Add Room</a>
                            <a href="#" class="btn btn-outline-dark">View Bookings</a>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection
