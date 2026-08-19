@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">

            @include('layouts.admin-panel')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                {{-- Header --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                    <div>
                        <h1 class="h3 mb-1">Users</h1>

                        <p class="text-muted mb-0">
                            Manage users and administrators
                        </p>
                    </div>

                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        Create user
                    </a>
                </div>


                {{-- Success message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif


                <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end mb-4">

                    <div class="col-lg-5 col-md-6">
                        <label for="search" class="form-label">
                            Search
                        </label>

                        <input type="text" name="search" id="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Search by name or email">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="role" class="form-label">
                            Role
                        </label>

                        <select name="role" id="role" class="form-select">
                            <option value="">All roles</option>

                            <option value="user" @selected(request('role') === 'user')>
                                User
                            </option>

                            <option value="admin" @selected(request('role') === 'admin')>
                                Admin
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Apply
                            </button>

                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                    </div>

                </form>

                {{-- Users table --}}
                <div class="card shadow-sm border-0">

                    <div
                        class="card-header bg-primary text-white
                        d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">
                            Users
                        </h4>

                        <span class="badge bg-light text-dark">
                            {{ $users->total() }} users
                        </span>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                        <th class="text-end pe-4">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($users as $user)
                                        @php
                                            $role =
                                                $user->role instanceof \App\Enums\RoleName
                                                    ? $user->role->value
                                                    : $user->role;
                                        @endphp

                                        <tr>
                                            <td class="ps-4">
                                                <strong>
                                                    #{{ $user->id }}
                                                </strong>
                                            </td>

                                            <td>
                                                <strong>
                                                    {{ $user->name }}
                                                </strong>
                                            </td>

                                            <td>
                                                {{ $user->email }}
                                            </td>

                                            <td>
                                                @if ($role === 'owner')
                                                    <span class="badge bg-dark">
                                                        Owner
                                                    </span>
                                                @elseif ($role === 'admin')
                                                    <span class="badge bg-primary">
                                                        Admin
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        User
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $user->created_at?->format('d.m.Y H:i') }}
                                            </td>

                                            <td class="text-end pe-4">

                                                <div class="d-inline-flex gap-2">

                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Edit
                                                    </a>

                                                    @if (!$user->isOwner() && $user->id !== auth()->id())
                                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                                            method="POST">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                                Delete
                                                            </button>

                                                        </form>
                                                    @endif

                                                </div>

                                            </td>
                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">

                                                No users found

                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @endif

            </main>

        </div>
    </div>
@endsection
