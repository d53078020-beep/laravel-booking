@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h1 class="h3 mb-1">
                            Create category
                        </h1>

                        <p class="text-muted mb-0">
                            Add a new hotel category
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.index') }}"
                        class="btn btn-outline-secondary">
                        Back
                    </a>

                </div>


                <div class="row">

                    <div class="col-lg-8 col-xl-6">

                        <div class="card shadow-sm border-0">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    Category information
                                </h5>
                            </div>

                            <div class="card-body p-4">

                                <form
                                    action="{{ route('admin.categories.store') }}"
                                    method="POST">

                                    @csrf


                                    {{-- Title --}}
                                    <div class="mb-3">

                                        <label for="title"
                                            class="form-label">
                                            Category title
                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            id="title"
                                            value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Example: Resort"
                                            required>

                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Slug --}}
                                    <div class="mb-4">

                                        <label for="slug"
                                            class="form-label">
                                            Slug
                                        </label>

                                        <input
                                            type="text"
                                            name="slug"
                                            id="slug"
                                            value="{{ old('slug') }}"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            placeholder="Example: resort">

                                        @error('slug')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="form-text">
                                            Used in URLs. Example: resort, apartment, villa.
                                        </div>


                                    </div>


                                    <div class="d-flex gap-2">

                                        <button type="submit"
                                            class="btn btn-primary">
                                            Create category
                                        </button>

                                        <a href="{{ route('admin.categories.index') }}"
                                            class="btn btn-outline-secondary">
                                            Cancel
                                        </a>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>
    </div>
@endsection