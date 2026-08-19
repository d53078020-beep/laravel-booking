@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h1 class="h3 mb-1">
                            Edit category
                        </h1>

                        <p class="text-muted mb-0">
                            Update category information
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

                                <div class="d-flex justify-content-between align-items-center">

                                    <h5 class="mb-0">
                                        Category information
                                    </h5>

                                    <span class="badge bg-light text-dark">
                                        #{{ $category->id }}
                                    </span>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <form
                                    action="{{ route('admin.categories.update', $category) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')


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
                                            value="{{ old('title', $category->title) }}"
                                            class="form-control @error('title') is-invalid @enderror"
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
                                            value="{{ old('slug', $category->slug) }}"
                                            class="form-control @error('slug') is-invalid @enderror">

                                        @error('slug')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="form-text">
                                            Used in URLs.
                                        </div>

                                    </div>


                                    <div class="d-flex gap-2">

                                        <button type="submit"
                                            class="btn btn-primary">
                                            Save changes
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