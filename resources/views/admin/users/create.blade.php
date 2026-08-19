@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Create user</h1>
                    <p class="text-muted mb-0">
                        Add a new user or administrator
                    </p>
                </div>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Back
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter user name"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="user@example.com"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">
                                Role
                            </label>

                            <select
                                name="role"
                                id="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required
                            >
                                <option value="">
                                    Select role
                                </option>

                                <option
                                    value="user"
                                    @selected(old('role') === 'user')
                                >
                                    User
                                </option>

                                @if(auth()->user()->isOwner())
                                    <option
                                        value="admin"
                                        @selected(old('role') === 'admin')
                                    >
                                        Admin
                                    </option>
                                @endif
                            </select>

                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-text">
                                Only the owner can create administrators.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimum 8 characters"
                                    required
                                >

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirm password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Repeat password"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a
                                href="{{ route('admin.users.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Create user
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection