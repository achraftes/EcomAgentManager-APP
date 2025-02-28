<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen w-screen overflow-hidden">
    <div class="flex h-full w-full">
        <!-- Image (left side) - takes up half the screen on larger displays -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/examples/exemple13.jpg') }}');">
            <!-- Background image only -->
        </div>
        
        <!-- Login form (right side) - takes up full width on mobile, half on larger screens -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-4">
            <div class="w-full max-w-md">
                <header class="mb-6">
                    <p class="text-2xl font-bold">
                        <span class="icon mr-2"><i class="mdi mdi-lock"></i></span>
                        Login
                    </p>
                </header>
                
                <!-- Laravel Auth Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email Address -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500"><i class="mdi mdi-account"></i></span>
                            <input class="w-full p-2 pl-10 border rounded" type="email" name="email" placeholder="user@example.com" autocomplete="username" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-600 text-sm mt-1">
                            Please enter your Email
                        </p>
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500"><i class="mdi mdi-asterisk"></i></span>
                            <input class="w-full p-2 pl-10 border rounded" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-600 text-sm mt-1">
                            Please enter your password
                        </p>
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="mr-2">
                            <span>Remember</span>
                        </label>
                    </div>
                    
                    <hr class="mb-4">
                    
                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                            Login
                        </button>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-600">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>