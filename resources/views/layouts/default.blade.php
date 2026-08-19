<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>StayBook</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header class="border-bottom bg-white sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light container py-3">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
                StayBook
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Hotels</a>
                    </li>

                    @auth
                        @if (auth()->user()->isAdmin() || auth()->user()->isOwner())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">
                                    Dashboard
                                </a>
                            </li>
                        @endif
                    @endauth

                    @if (auth()->user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('booking.index') }}">
                                My Bookings <span class="badge bg-primary rounded-pill"> {{ $activeBookingsCount }}
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- Right side --}}
                <div class="d-flex align-items-center gap-2">

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-dark">
                            Login
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-dark">
                            Register
                        </a>
                    @endguest

                    @auth
                        <span class="fw-semibold me-2">
                            {{ auth()->user()->name }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button class="btn btn-outline-danger">
                                Logout
                            </button>
                        </form>
                    @endauth

                    </ul>
                </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>


    <button class="btn btn-dark position-fixed bottom-0 end-0 m-4 rounded-pill px-4 py-2 shadow" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#aiAssistant">
        ✨ AI Assistant
    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="aiAssistant" style="width: 400px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                StayBook AI Assistant
            </h5>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column">

            <div id="aiMessages" class="flex-grow-1 overflow-auto mb-3" style="max-height: 70vh;">
                <div class="alert alert-light border">
                    Hi! Tell me what kind of hotel you're looking for.
                </div>
            </div>

            <form id="aiForm">
                @csrf

                <div class="input-group">
                    <input type="text" id="aiMessage" class="form-control"
                        placeholder="Hotel for 2 in Greece under $200..." maxlength="1000" required>

                    <button class="btn btn-primary" type="submit" id="aiSendButton">
                        Send
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.getElementById('aiForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const input = document.getElementById('aiMessage');
            const messages = document.getElementById('aiMessages');
            const button = document.getElementById('aiSendButton');

            const message = input.value.trim();

            if (!message) {
                return;
            }

            // Показуємо повідомлення користувача
            messages.innerHTML += `
        <div class="d-flex justify-content-end mb-3">
            <div class="bg-primary text-white rounded p-3" style="max-width: 85%;">
                ${escapeHtml(message)}
            </div>
        </div>
    `;

            input.value = '';
            button.disabled = true;
            button.innerText = 'Thinking...';

            messages.scrollTop = messages.scrollHeight;

            try {
                const response = await fetch('{{ route('ai.assistant') }}', {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                    body: JSON.stringify({
                        message: message
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message ?? 'Something went wrong');
                }

                // Тут data вже існує
                let aiHtml = `
            <div class="d-flex justify-content-start mb-3">
                <div style="max-width: 90%; width: 100%;">

                    <div class="bg-light border rounded p-3 mb-3">
                        ${escapeHtml(data.message)}
                    </div>
        `;

                if (data.recommendations && data.recommendations.length > 0) {

                    data.recommendations.forEach(hotel => {

                        aiHtml += `
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">

                            <h5 class="card-title mb-1">
                                ${escapeHtml(hotel.hotel_name)}
                            </h5>

                            <div class="text-muted mb-2">
                                ${escapeHtml(hotel.location)}
                            </div>

                            <div class="mb-2">
                                ⭐ ${hotel.rating}
                            </div>

                            <div class="mb-2">
                                <strong>Room:</strong>
                                ${escapeHtml(hotel.room_type)}
                            </div>

                            <div class="mb-2">
                                <strong>$${hotel.price}</strong> / night
                            </div>

                            <p class="card-text small">
                                ${escapeHtml(hotel.reason)}
                            </p>

                            <a
    href="/hotel/${encodeURIComponent(hotel.hotel_slug)}"
    class="btn btn-dark btn-sm"
>
    View Hotel
</a>

                        </div>
                    </div>
                `;
                    });
                }

                aiHtml += `
                </div>
            </div>
        `;

                messages.innerHTML += aiHtml;

            } catch (error) {

                messages.innerHTML += `
            <div class="alert alert-danger">
                ${escapeHtml(error.message)}
            </div>
        `;

            } finally {

                button.disabled = false;
                button.innerText = 'Send';

                messages.scrollTop = messages.scrollHeight;
                input.focus();
            }
        });


        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text ?? '';

            return div.innerHTML;
        }
    </script>

</body>

</html>
