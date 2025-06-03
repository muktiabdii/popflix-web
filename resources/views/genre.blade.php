<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre: {{ $genreName }}</title>
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
    <!-- Header with Breadcrumb -->
    <header class="bg-dark-gray shadow py-4 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $genreName }}</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="/login"
                            class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Login</a>
                    @endguest
                    <a href="/watchlist"
                        class="px-4 py-2 bg-slate-blue text-light-gray rounded hover:bg-soft-blue">Watchlist</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Year Filter and Movie Grid -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Year Filter Dropdown -->
            <div class="mb-6">
                <form action="{{ route('filter.genre', $genreId) }}" method="GET">
                    <select name="year" id="yearFilter"
                        class="bg-dark-gray text-light-gray border border-gray-secondary rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-soft-blue hover:bg-slate-blue transition-colors duration-200">
                        <option value="" class="bg-dark-gray">All Years</option>
                        @for ($i = date('Y'); $i >= 1900; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }} class="bg-dark-gray">{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <!-- Movie Grid -->
            @if ($results->isEmpty())
                <div class="text-center text-gray-secondary text-xl">No movies found for this
                    genre{{ $year ? ' in ' . $year : '' }}.</div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($results as $movie)
                        <div class="bg-dark-gray rounded-lg overflow-hidden shadow hover:shadow-[0_0_10px_#2E82FF]">
                            <img src="{{ $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'] : 'https://via.placeholder.com/500x750?text=No+Poster' }}"
                                alt="{{ $movie['title'] }}" class="w-full h-64 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold truncate">{{ $movie['title'] }}</h3>
                                <p class="text-gray-secondary">Rating: {{ number_format($movie['vote_average'], 1) }}/10</p>
                                <a href="/movie/{{ $movie['id'] }}"
                                    class="mt-2 inline-block px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($results->hasPages())
                    <div class="mt-8 flex justify-center">
                        <div class="flex space-x-2">
                            {{ $results->appends(['genre_id' => $genreId, 'year' => $year])->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-gray py-4 text-center">
        <p class="text-gray-secondary">Powered by <a href="https://www.themoviedb.org/" target="_blank"
                class="text-crimson-red hover:text-soft-blue">TMDb</a></p>
        <p class="text-gray-secondary">Created by Your Name</p>
    </footer>

    <script>
        document.getElementById('yearFilter').addEventListener('change', function () {
            this.form.submit();
        });
    </script>
</body>

</html>