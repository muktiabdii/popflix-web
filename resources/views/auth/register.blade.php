<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar ke PopFlix</title>
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
    <div class="bg-dark-gray rounded-lg shadow p-8 max-w-md w-full">
        <h1 class="text-3xl font-bold text-crimson-red mb-6 text-center">Register</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-secondary mb-2">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 bg-gray-secondary text-black rounded focus:outline-none focus:ring-2 focus:ring-soft-blue @error('name') border border-crimson-red @enderror">
                @error('name')
                    <p class="text-crimson-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-secondary mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 bg-gray-secondary text-black rounded focus:outline-none focus:ring-2 focus:ring-soft-blue @error('email') border border-crimson-red @enderror">
                @error('email')
                    <p class="text-crimson-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-secondary mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 bg-gray-secondary text-black rounded focus:outline-none focus:ring-2 focus:ring-soft-blue @error('password') border border-crimson-red @enderror">
                @error('password')
                    <p class="text-crimson-red text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-secondary mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 bg-gray-secondary text-black rounded focus:outline-none focus:ring-2 focus:ring-soft-blue">
            </div>

            <!-- Checkbox: Show Password -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="show-password" class="mr-2">
                    <span class="text-gray-secondary">Show Password</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full px-4 py-2 bg-crimson-red text-light-gray rounded hover:bg-soft-blue">Register</button>
        </form>
        <p class="text-gray-secondary text-center mt-4">Already have an account? <a href="{{ route('login') }}" class="text-crimson-red hover:text-soft-blue">Login</a></p>
    </div>
    <script>
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        showPasswordCheckbox.addEventListener('change', function () {
            const type = this.checked ? 'text' : 'password';
            passwordInput.type = type;
            confirmPasswordInput.type = type;
        });
    </script> 
</body>
</html>