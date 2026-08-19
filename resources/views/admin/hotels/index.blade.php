@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            @include('layouts.admin-panel')


            {{-- Main content --}}
            <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">

                <div class="container-fluid py-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Hotels</h2>

                        <a href="{{ route('admin.hotels.basket') }}" class="btn btn-outline-danger position-relative">
                            Basket

                            @if (\App\Models\Hotel::onlyTrashed()->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ \App\Models\Hotel::onlyTrashed()->count() }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary">
                            + Add Hotel
                        </a>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th width="120">Photo</th>
                                            <th>Hotel</th>
                                            <th width="180">Starting price</th>
                                            <th width="150">Rating</th>
                                            <th width="120">Category</th>
                                            <th width="180" class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($hotels as $hotel)
                                            <tr>

                                                <td>
                                                    <span>{{ $hotel->id }}</span>
                                                </td>

                                                <td>
                                                    <img src="{{ asset('storage/' . $hotel->image) }}"
                                                        style="width:120px;height:80px;object-fit:cover;" class="rounded">
                                                </td>

                                                <td>
                                                    <h6 class="mb-1">{{ $hotel->title }}</h6>
                                                    <small class="text-muted">{{ $hotel->location }}</small>
                                                </td>

                                                <td>
                                                    <strong>${{ $hotel->price }}</strong>
                                                    <div class="text-muted small">per night</div>
                                                </td>

                                                <td>
                                                    ⭐ {{ $hotel->rate }}
                                                </td>

                                                <td>
                                                    {{ $hotel->category?->title ?? 'No category' }}
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">

                                                        <a href="{{ route('admin.hotels.edit', $hotel) }}"
                                                            class="btn btn-sm btn-warning">
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('admin.hotels.destroy', $hotel) }}"
                                                            method="POST" class="m-0">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Confirm action?')">
                                                                Delete
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>
@endsection
