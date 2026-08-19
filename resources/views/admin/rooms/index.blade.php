@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row">

        @include('layouts.admin-panel')

        <main class="col-lg-10 col-md-9 p-4 bg-light min-vh-100">

            <div class="container-fluid py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Rooms</h2>

                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                        + Add Room
                    </a>
                </div>

                <div class="card shadow-sm border-0">

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Hotel ID</th>
                                        <th width="120">Photo</th>
                                        <th>Room</th>
                                        <th>Hotel</th>
                                        <th width="120">Capacity</th>
                                        <th width="140">Price</th>
                                        <th width="120">Status</th>
                                        <th width="180" class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($rooms as $room)

                                        <tr>

                                            <td>
                                                <span>
                                                    {{ $room->hotel_id }}
                                                </span>
                                            </td>


                                            <td>
                                                <img
                                                    src="{{ asset('storage/'.$room->image) }}"
                                                    class="rounded"
                                                    style="width:120px;height:80px;object-fit:cover;">
                                            </td>

                                            <td>
                                                <h6 class="mb-1">{{ $room->title }}</h6>

                                                <small class="text-muted">
                                                    {{ Str::limit($room->description,60) }}
                                                </small>
                                            </td>

                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $room->hotel->title }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $room->capacity }} Guests
                                            </td>

                                            <td>
                                                <strong>${{ $room->price }}</strong>
                                                <div class="small text-muted">
                                                    per night
                                                </div>
                                            </td>

                                            <td>
                                                @if($room->status)
                                                    <span class="badge bg-success">
                                                        Available
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        Unavailable
                                                    </span>
                                                @endif
                                            </td>

                                            <td>

                                                <div class="d-flex justify-content-center gap-2">

                                                    <a
                                                        href="{{ route('admin.rooms.edit',$room) }}"
                                                        class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('admin.rooms.destroy',$room) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this room?')">
                                                            Delete
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="mt-4">
                    {{ $rooms->links() }}
                </div>

            </div>

        </main>

    </div>
</div>
@endsection