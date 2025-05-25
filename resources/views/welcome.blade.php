<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Database</title>
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
    <!-- Header -->
    <header class="bg-dark-gray shadow py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
            <div class="text-2xl font-bold text-crimson-red">MovieDB</div>
            <div class="flex items-center space-x-4">
                <input type="text" id="searchInput" placeholder="Search movies..." class="px-4 py-2 rounded bg-gray-secondary text-light-gray focus:outline-none focus:ring-2 focus:ring-soft-blue">
                <a href="{{ route('register') }}" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Register</a>
                <a href="/login" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Login</a>
                <a href="/watchlist" class="px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue">Watchlist</a>
            </div>
        </div>
    </header>

    <!-- Popular Movies -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6">Film Populer</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($popularMovies as $movie)
                    <div class="bg-dark-gray rounded-lg overflow-hidden shadow hover:shadow-[0_0_10px_#2E82FF]">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold truncate">{{ $movie['title'] }}</h3>
                            <p class="text-gray-secondary">Rating: {{ number_format($movie['vote_average'], 1) }}/10</p>
                            <a href="/movie/{{ $movie['id'] }}" class="mt-2 inline-block px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Now Playing Movies -->
    <section class="py-8 bg-gray-secondary bg-opacity-10">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6">Sedang Tayang</h2>
            <div class="flex overflow-x-auto space-x-4 pb-4">
                @foreach ($nowPlayingMovies as $movie)
                    <div class="bg-dark-gray rounded-lg overflow-hidden shadow hover:shadow-[0_0_10px_#2E82FF] flex-none w-48">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold truncate">{{ $movie['title'] }}</h3>
                            <p class="text-gray-secondary">Rating: {{ number_format($movie['vote_average'], 1) }}/10</p>
                            <a href="/movie/{{ $movie['id'] }}" class="mt-2 inline-block px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Genre Filter -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6">Filter Genre</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($genres as $genre)
                    <button class="genre-button px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue" data-genre-id="{{ $genre['id'] }}">{{ $genre['name'] }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-gray py-4 text-center">
        <p class="text-gray-secondary">Powered by <a href="https://www.themoviedb.org/" target="_blank" class="text-crimson-red hover:text-soft-blue">TMDb</a></p>
        <p class="text-gray-secondary">Created by Your Name</p>
    </footer>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', async function(e) {
            const query = e.target.value;
            if (query.length < 3) return;

            const response = await fetch(`/search?query=${encodeURIComponent(query)}`);
            const results = await response.json();
            console.log('Search results:', results); // Replace with UI update logic
        });

        // Genre filter functionality
        document.querySelectorAll('.genre-button').forEach(button => {
            button.addEventListener('click', async function() {
                const genreId = this.dataset.genreId;
                const response = await fetch(`/filter-genre?genre_id=${genreId}`);
                const results = await response.json();
                console.log('Filtered movies:', results); // Replace with UI update logic
            });
        });
    </script>
</body>
</html>