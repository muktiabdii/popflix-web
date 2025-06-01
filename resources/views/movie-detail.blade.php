<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie['title'] }} ({{ substr($movie['release_date'], 0, 4) }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gunmetal-black': '#0D0D0D',
                        'dark-gray': '#1E1E1E',
                        'crimson-red': '#E50914',
                        'slate-blue': '#3A3D98',
                        'light-gray': '#EDEDED',
                        'gray-secondary': '#AAAAAA',
                        'soft-blue': '#2E82FF',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gunmetal-black text-light-gray">
    <!-- Toast Container -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div id="toastMessage" class="bg-crimson-red text-light-gray px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2">
            <span id="toastText"></span>
            <button id="closeToast" class="text-light-gray hover:text-gray-secondary">✕</button>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-dark-gray shadow py-4">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-crimson-red">{{ $movie['title'] }}</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Home</a>
                @auth
                    <a href="{{ route('watchlist') }}" class="px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue">Watchlist</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Register</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-8">
            <!-- Left: Poster -->
            <div class="md:w-1/3">
                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full rounded-lg shadow">
            </div>

            <!-- Right: Details -->
            <div class="md:w-2/3">
                <h2 class="text-2xl font-semibold">{{ $movie['title'] }} ({{ substr($movie['release_date'], 0, 4) }})</h2>
                <p class="text-gray-secondary mb-4">{{ $movie['release_date'] }}</p>

                <!-- Genres -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($movie['genres'] as $genre)
                        <span class="px-3 py-1 bg-slate-blue text-light-gray rounded-full text-sm">{{ $genre['name'] }}</span>
                    @endforeach
                </div>

                <!-- Duration -->
                <p class="text-gray-secondary mb-4">Duration: {{ floor($movie['runtime'] / 60) }}h {{ $movie['runtime'] % 60 }}m</p>

                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <p class="text-gray-secondary">Rating: </p>
                    <div class="ml-2">
                        @php
                            $rating = round($movie['vote_average'] / 2);
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-secondary' }}">★</span>
                        @endfor
                        <span class="text-gray-secondary ml-2">({{ number_format($movie['vote_average'], 1) }}/10)</span>
                    </div>
                </div>

                <!-- Synopsis -->
                <h3 class="text-xl font-semibold mb-2">Synopsis</h3>
                <p class="text-gray-secondary mb-4">{{ $movie['overview'] ?: 'No synopsis available.' }}</p>

                <!-- Buttons -->
                <div class="flex gap-4">
                    @if ($trailer)
                        <button id="trailerButton" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Tonton Trailer</button>
                    @endif
                    @auth
                        <form method="POST" action="{{ route('watchlist.add') }}">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                            <input type="hidden" name="movie_title" value="{{ $movie['title'] }}">
                            <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] }}">
                            <button type="submit" class="px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue">Tambah ke Watchlist</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue">Login to Add to Watchlist</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Trailer Modal -->
    @if ($trailer)
        <div id="trailerModal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50">
            <div class="bg-dark-gray p-4 rounded-lg max-w-3xl w-full">
                <div class="flex justify-end">
                    <button id="closeModal" class="text-gray-secondary hover:text-light-gray">✕</button>
                </div>
                <iframe class="w-full h-96" src="https://www.youtube.com/embed/{{ $trailer['key'] }}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-dark-gray py-4 text-center">
        <p class="text-gray-secondary">Powered by <a href="https://www.themoviedb.org/" target="_blank" class="text-crimson-red hover:text-soft-blue">TMDb</a></p>
        <p class="text-gray-secondary">Created by Your Name</p>
    </footer>

    <script>
        // Toast Notification
        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toastText');
            const toastMessage = document.getElementById('toastMessage');
            
            toastText.textContent = message;
            toastMessage.className = `px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2 ${isError ? 'bg-red-600' : 'bg-crimson-red'} text-light-gray`;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        document.getElementById('closeToast')?.addEventListener('click', () => {
            document.getElementById('toast').classList.add('hidden');
        });

        // Check for flash messages on page load
        window.addEventListener('load', () => {
            const successMessage = @json(session('success'));
            const errors = @json($errors->all());

            if (successMessage) {
                showToast(successMessage);
            }
            errors.forEach(error => {
                showToast(error, true);
            });
        });

        // Trailer Modal
        const trailerButton = document.getElementById('trailerButton');
        const trailerModal = document.getElementById('trailerModal');
        const closeModal = document.getElementById('closeModal');

        if (trailerButton && trailerModal && closeModal) {
            trailerButton.addEventListener('click', () => {
                trailerModal.classList.remove('hidden');
            });

            closeModal.addEventListener('click', () => {
                trailerModal.classList.add('hidden');
                const iframe = trailerModal.querySelector('iframe');
                if (iframe) iframe.src = iframe.src;
            });

            trailerModal.addEventListener('click', (e) => {
                if (e.target === trailerModal) {
                    trailerModal.classList.add('hidden');
                    const iframe = trailerModal.querySelector('iframe');
                    if (iframe) iframe.src = iframe.src;
                }
            });
        }
    </script>
</body>
</html>