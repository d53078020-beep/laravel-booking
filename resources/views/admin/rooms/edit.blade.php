@extends('layouts.default')

@section('title', 'Edit Room')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Edit Room</h2>
            <small class="text-muted">Update hotel room information</small>
        </div>

        <a href="{{ route('admin.rooms.index') }}"
           class="btn btn-outline-secondary">
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

            <form action="{{ route('admin.rooms.update', $room) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Hotel --}}
                <div class="mb-3">
                    <label for="hotel_id" class="form-label">
                        Hotel
                    </label>

                    <select
                        name="hotel_id"
                        id="hotel_id"
                        class="form-select @error('hotel_id') is-invalid @enderror">

                        <option value="">Choose hotel...</option>

                        @foreach($hotels as $hotel)
                            <option
                                value="{{ $hotel->id }}"
                                @selected(old('hotel_id', $room->hotel_id) == $hotel->id)>

                                {{ $hotel->title }}
                            </option>
                        @endforeach

                    </select>

                    @error('hotel_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">

                    {{-- Room Type --}}
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">
                            Room Type
                        </label>

                        <input
                            type="text"
                            id="type"
                            name="type"
                            class="form-control @error('type') is-invalid @enderror"
                            value="{{ old('type', $room->type) }}"
                            placeholder="Deluxe Room">

                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Quantity Rooms --}}
                    <div class="col-md-6 mb-3">
                        <label for="quantity_rooms" class="form-label">
                            Quantity Rooms
                        </label>

                        <input
                            type="number"
                            id="quantity_rooms"
                            name="quantity_rooms"
                            min="1"
                            class="form-control @error('quantity_rooms') is-invalid @enderror"
                            value="{{ old('quantity_rooms', $room->quantity_rooms) }}">

                        @error('quantity_rooms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="row">

                    {{-- Capacity --}}
                    <div class="col-md-6 mb-3">
                        <label for="capacity" class="form-label">
                            Capacity
                        </label>

                        <input
                            type="number"
                            id="capacity"
                            name="capacity"
                            min="1"
                            class="form-control @error('capacity') is-invalid @enderror"
                            value="{{ old('capacity', $room->capacity) }}">

                        @error('capacity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">
                            New Image
                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                            class="form-control @error('image') is-invalid @enderror">

                        <div class="form-text">
                            Leave empty to keep the current image.
                        </div>

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Current Image --}}
                @if($room->image)
                    <div class="mb-3">
                        <label class="form-label d-block">
                            Current Image
                        </label>

                        <img
                            src="{{ asset('storage/' . $room->image) }}"
                            alt="{{ $room->type }}"
                            class="img-thumbnail"
                            style="width: 220px; height: 140px; object-fit: cover;">
                    </div>
                @endif

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Room description...">{{ old('description', $room->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Prices</h5>

                <div class="row">

                    {{-- Room Price --}}
                    <div class="col-md-3 mb-3">
                        <label for="price" class="form-label">
                            Room Price ($)
                        </label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="0.01"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $room->price) }}">

                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Breakfast --}}
                    <div class="col-md-3 mb-3">
                        <label for="breakfast_price" class="form-label">
                            Breakfast ($)
                        </label>

                        <input
                            type="number"
                            id="breakfast_price"
                            name="breakfast_price"
                            min="0"
                            step="0.01"
                            class="form-control @error('breakfast_price') is-invalid @enderror"
                            value="{{ old('breakfast_price', $room->breakfast_price) }}">

                        @error('breakfast_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Half Board --}}
                    <div class="col-md-3 mb-3">
                        <label for="half_board_price" class="form-label">
                            Half Board ($)
                        </label>

                        <input
                            type="number"
                            id="half_board_price"
                            name="half_board_price"
                            min="0"
                            step="0.01"
                            class="form-control @error('half_board_price') is-invalid @enderror"
                            value="{{ old('half_board_price', $room->half_board_price) }}">

                        @error('half_board_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- All Inclusive --}}
                    <div class="col-md-3 mb-3">
                        <label for="all_inclusive_price" class="form-label">
                            All Inclusive ($)
                        </label>

                        <input
                            type="number"
                            id="all_inclusive_price"
                            name="all_inclusive_price"
                            min="0"
                            step="0.01"
                            class="form-control @error('all_inclusive_price') is-invalid @enderror"
                            value="{{ old('all_inclusive_price', $room->all_inclusive_price) }}">

                        @error('all_inclusive_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-primary px-4">
                        Update Room
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
```
