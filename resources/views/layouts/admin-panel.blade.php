{{-- Sidebar --}}
            <aside class="col-lg-2 col-md-3 bg-dark text-white min-vh-100 p-3">
                <h4 class="mb-4">Admin Panel</h4>

                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.index') }}" class="nav-link text-white">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.hotels.index') }}" class="nav-link text-white">
                            Hotels
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.rooms.index')}}" class="nav-link text-white">
                            Rooms
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.bookings.index')}}" class="nav-link text-white">
                            Bookings
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.categories.index')}}" class="nav-link text-white">
                            Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.users.index')}}" class="nav-link text-white">
                            Users
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-white">
                            Back to site
                        </a>
                    </li>
                </ul>
            </aside>