@extends('layouts.default')

@section('title', 'Create Room')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Create Room</h2>
            <small class="text-muted">Add a new hotel room</small>
        </div>

        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
            ← Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.rooms.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- Hotel --}}
                <div class="mb-3">
                    <label class="form-label">Hotel</label>

                    <select name="hotel_id" class="form-select">
                        <option value="">Choose hotel...</option>

                        @foreach($hotels as $hotel)
                            <option
                                value="{{ $hotel->id }}"
                                @selected(old('hotel_id') == $hotel->id)>
                                {{ $hotel->title }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Room Type</label>

                        <input
                            type="text"
                            class="form-control"
                            name="type"
                            value="{{ old('type') }}"
                            placeholder="Deluxe Room">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity Rooms</label>

                        <input
                            type="number"
                            class="form-control"
                            name="quantity_rooms"
                            value="{{ old('quantity_rooms') }}">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Capacity</label>

                        <input
                            type="number"
                            class="form-control"
                            name="capacity"
                            value="{{ old('capacity') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>

                        <input
                            type="file"
                            class="form-control"
                            name="image">
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label">Description</label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control"
                        placeholder="Room description...">{{ old('description') }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Prices</h5>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Room Price ($)</label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="price"
                            value="{{ old('price') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Breakfast ($)</label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="breakfast_price"
                            value="{{ old('breakfast_price') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Half Board ($)</label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="half_board_price"
                            value="{{ old('half_board_price') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">All Inclusive ($)</label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="all_inclusive_price"
                            value="{{ old('all_inclusive_price') }}">
                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary px-4">
                        Create Room
                    </button>

                    <a href="{{ route('admin.rooms.index') }}"
                       class="btn btn-light ms-2">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection