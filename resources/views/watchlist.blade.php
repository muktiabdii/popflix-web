<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist - Movie Database</title>
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

    <header class="bg-dark-gray shadow py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
            <div class="text-2xl font-bold text-crimson-red">MovieDB</div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Home</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-6">Watchlist Saya</h2>
            @if ($watchlist->isEmpty())
                <p class="text-gray-secondary">Belum ada film di watchlist.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($watchlist as $item)
                        <div class="bg-dark-gray rounded-lg overflow-hidden shadow hover:shadow-[0_0_10px_#2E82FF]">
                            <img src="https://image.tmdb.org/t/p/w500{{ $item->poster_path }}" alt="{{ $item->movie_title }}" class="w-full h-64 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold truncate">{{ $item->movie_title }}</h3>
                                <form method="POST" action="{{ route('watchlist.remove') }}">
                                    @csrf
                                    <input type="hidden" name="movie_id" value="{{ $item->movie_id }}">
                                    <button type="submit" class="mt-2 inline-block px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Hapus dari Watchlist</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

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
    </script>
</body>
</html>