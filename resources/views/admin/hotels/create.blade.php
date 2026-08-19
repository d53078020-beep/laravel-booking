@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">
                <div class="container-fluid py-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white">
                                    <h4 class="mb-0">Create Hotel</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.hotels.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{-- Hotel title --}}
                                        <div class="mb-3">
                                            <label class="form-label">Hotel title</label>

                                            <input type="text" name="title" class="form-control"
                                                value="{{ old('title') }}" placeholder="Hilton Resort">

                                            @error('title')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Location --}}
                                        <div class="mb-3">
                                            <label class="form-label">Location</label>

                                            <input type="text" name="location" class="form-control"
                                                value="{{ old('location') }}" placeholder="Crete, Greece">

                                            @error('location')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Starting price --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Starting price ($)
                                            </label>

                                            <input type="number" step="0.01" name="price" class="form-control"
                                                value="{{ old('price') }}">

                                            @error('price')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Rating --}}
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>

                                            <input type="number" step="0.1" min="0" max="5"
                                                name="rate" class="form-control" value="{{ old('rate') }}"
                                                placeholder="4.8">

                                            @error('rate')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Image --}}
                                        <div class="mb-3">
                                            <label class="form-label">Hotel image</label>

                                            <input type="file" name="image" class="form-control">

                                            @error('image')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Description --}}
                                        <div class="mb-4">
                                            <label class="form-label">Description</label>

                                            <textarea name="description" rows="6" class="form-control" placeholder="Hotel description...">{{ old('description') }}</textarea>

                                            @error('description')
                                                <div class="text-danger small">{{ $message }}</div>
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
                                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
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

                                            <button class="btn btn-primary">
                                                Create Hotel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
