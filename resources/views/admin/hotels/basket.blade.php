@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
                               
            @include('layouts.admin-panel')


            <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">
                <div class="container-fluid py-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Basket</h2>

                        <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-secondary">
                            Back to hotels
                        </a>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th width="130">Photo</th>
                                            <th>Hotel</th>
                                            <th width="180">Starting price</th>
                                            <th width="140">Rating</th>
                                            <th width="220" class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($hotels as $hotel)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $hotel->image) }}"
                                                        alt="{{ $hotel->title }}" class="rounded border"
                                                        style="width:120px;height:80px;object-fit:cover;">
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

                                                <td class="text-center">

                                                    <form action="{{ route('admin.hotels.restore', $hotel->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Restore
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.hotels.basketRemove', $hotel->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Delete this hotel forever?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <h5 class="mb-2">Basket is empty</h5>
                                                    <p class="text-muted mb-3">
                                                        There are no deleted hotels yet.
                                                    </p>

                                                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-primary">
                                                        Back to hotels
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse

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
