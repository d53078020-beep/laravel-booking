@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">
                <div class="container-fluid py-4">

                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-0">Edit Hotel</h2>

                                <a href="{{ route('admin.hotels.index') }}" class="btn btn-outline-secondary">
                                    Back
                                </a>
                            </div>

                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label class="form-label">Hotel title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ old('title', $hotel->title) }}">

                                            @error('title')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control"
                                                value="{{ old('location', $hotel->location) }}">

                                            @error('location')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Starting price ($)</label>
                                                <input type="number" name="price" step="0.01" class="form-control"
                                                    value="{{ old('price', $hotel->price) }}">

                                                @error('price')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Rating</label>
                                                <input type="number" name="rate" step="0.1" min="0"
                                                    max="5" class="form-control"
                                                    value="{{ old('rate', $hotel->rate) }}">

                                                @error('rate')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Current image</label>

                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $hotel->image) }}"
                                                    alt="{{ $hotel->title }}" class="rounded border"
                                                    style="width: 180px; height: 120px; object-fit: cover;">
                                            </div>

                                            <input type="file" name="image" class="form-control">

                                            <div class="form-text">
                                                Leave empty if you do not want to change the image.
                                            </div>

                                            @error('image')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="6" class="form-control">{{ old('description', $hotel->description) }}</textarea>

                                            @error('description')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">
                                                Category
                                            </label>

                                            <select name="category_id" id="category_id"
                                                class="form-select @error('category_id') is-invalid @enderror" required>
                                                <option value="">Select category</option>

                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(old('category_id', $hotel->category_id) == $category->id)>
                                                        {{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('category_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">
                                                Cancel
                                            </a>

                                            <button type="submit" class="btn btn-primary">
                                                Update Hotel
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>
            </main>
        </div>

    </div>
@endsection
