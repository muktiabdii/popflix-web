<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - PopFlix</title>
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

<body class="bg-gunmetal-black text-light-gray min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-dark-gray shadow py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
            <div class="text-2xl font-bold text-crimson-red">PopFlix</div>
            <nav class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-slate-blue rounded hover:bg-soft-blue transition">Home</a>
                <a href="{{ route('watchlist') }}" class="px-4 py-2 bg-slate-blue rounded hover:bg-soft-blue transition">Watchlist</a>
            </nav>
        </div>
    </header>

    <!-- Profile Section -->
    <main class="flex-grow py-12 px-4 max-w-7xl mx-auto">
        <h2 class="text-4xl font-bold mb-10 text-center">User Profile</h2>

        <div class="bg-dark-gray rounded-lg shadow-lg p-8 flex flex-col items-center gap-8 w-full max-w-5xl mx-auto">
            <!-- Foto Profil -->
            <div class="w-36 h-36 rounded-full bg-gray-700 flex items-center justify-center overflow-hidden border-4 border-crimson-red shadow-lg mb-4">
                @if(Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo" class="w-full h-full object-cover" />
                @else
                    <span class="text-gray-secondary text-5xl font-bold uppercase">
                        {{ substr(Auth::user()->name ?? Auth::user()->email, 0, 1) }}
                    </span>
                @endif
            </div>

            <!-- Form Edit Profile -->
            <form action="{{ route('profile.update') }}" method="POST" class="w-full space-y-6" novalidate>
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block mb-2 text-gray-secondary font-semibold">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', Auth::user()->name) }}"
                        class="w-full px-4 py-3 rounded bg-gray-800 text-light-gray border border-soft-blue focus:outline-none focus:ring-2 focus:ring-soft-blue transition"
                    />
                    @error('name')
                        @php /** @var string $message */ @endphp
                        <p class="text-crimson-red text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-gray-secondary font-semibold">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', Auth::user()->email) }}"
                        class="w-full px-4 py-3 rounded bg-gray-800 text-light-gray border border-soft-blue focus:outline-none focus:ring-2 focus:ring-soft-blue transition"
                    />
                    @error('email')
                        @php /** @var string $message */ @endphp
                        <p class="text-crimson-red text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 bg-slate-blue rounded hover:bg-soft-blue text-light-gray font-semibold transition"
                >
                    Update Profile
                </button>
            </form>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="max-w-5xl mx-auto mt-10">
            @csrf
            <button
                type="submit"
                class="w-full py-3 bg-crimson-red rounded hover:bg-soft-blue text-light-gray font-semibold transition"
            >
                Logout
            </button>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-dark-gray py-6 text-center text-gray-secondary text-sm">
        <p>Powered by <a href="https://www.themoviedb.org/" target="_blank" class="text-crimson-red hover:text-soft-blue">TMDb</a></p>
        <p>Created with ❤️ by PopFlix Team</p>
    </footer>
</body>
</html>