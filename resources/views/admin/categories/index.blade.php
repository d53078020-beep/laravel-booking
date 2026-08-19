@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1">Categories</h1>
                        <p class="text-muted mb-0">
                            Manage hotel categories
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.create') }}"
                        class="btn btn-primary">
                        Add category
                    </a>
                </div>


                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show"
                        role="alert">

                        {{ session('success') }}

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif


                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white
                        d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">
                            Categories
                        </h4>

                        <span class="badge bg-light text-dark">
                            {{ $categories->total() }} categories
                        </span>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Hotels</th>
                                        <th>Created</th>
                                        <th class="text-end pe-4">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($categories as $category)

                                        <tr>

                                            <td class="ps-4">
                                                <strong>
                                                    #{{ $category->id }}
                                                </strong>
                                            </td>

                                            <td>
                                                <strong>
                                                    {{ $category->title }}
                                                </strong>
                                            </td>

                                            <td>
                                                <span class="text-muted">
                                                    {{ $category->slug }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $category->hotels_count ?? $category->hotels()->count() }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $category->created_at?->format('d.m.Y H:i') }}
                                            </td>

                                            <td class="text-end pe-4">

                                                <div class="d-inline-flex gap-2">

                                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('admin.categories.destroy', $category) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                                            Delete
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6"
                                                class="text-center text-muted py-5">
                                                No categories found
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                @if ($categories->hasPages())
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @endif

            </main>

        </div>
    </div>
@endsection