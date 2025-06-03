<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke PopFlix</title>
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
<body class="bg-gunmetal-black text-light-gray flex items-center justify-center min-h-screen">
    <div class="bg-dark-gray rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-3xl font-bold text-crimson-red mb-6 text-center">Login</h2>
        
        @if (session('error'))
            <div class="bg-crimson-red text-light-gray p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-crimson-red text-light-gray p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-secondary mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 bg-gray-secondary text-light-gray rounded focus:outline-none focus:ring-2 focus:ring-soft-blue" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-secondary mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-gray-secondary text-light-gray rounded focus:outline-none focus:ring-2 focus:ring-soft-blue" required>
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Login</button>
        </form>

        <p class="text-gray-secondary text-center mt-4">
            Belum punya akun? <a href="/register" class="text-crimson-red hover:text-soft-blue">Register</a>
        </p>
        <p class="text-gray-secondary text-center mt-2">
            Lupa password? <a href="{{ route('password.request') }}" class="text-crimson-red hover:text-soft-blue">Reset Password</a>
        </p>
    </div>
</body>
</html>