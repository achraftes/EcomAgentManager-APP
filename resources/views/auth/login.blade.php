<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

<section class="section main-section flex justify-center items-center min-h-screen bg-white ">
    <div class="card max-w-6xl w-full h-full flex">
        <div class="card-content flex flex-row gap-8 h-full w-full">
            <!-- Image (côté gauche) -->
            <div class="flex-1 flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('img/examples/exemple13.jpg') }}');">
                <!-- L'image est utilisée comme fond, donc pas besoin de balise img ici -->
            </div>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            <!-- Formulaire de connexion (côté droit) -->
            <div class="flex-1 flex flex-col justify-center p-8 bg-white">
                <header class="card-header mb-6">
                    <p class="card-header-title text-2xl font-bold">
                        <span class="icon"><i class="mdi mdi-lock"></i></span>
                        Login
                    </p>
                </header>
                <div class="card-content">
                    <!-- Laravel Auth Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email Address -->
                        <div class="field spaced mb-4">
                            <label class="label font-medium">Email</label>
                            <div class="control icons-left">
                                <input class="input w-full p-2 border rounded" type="email" name="email" placeholder="user@example.com" autocomplete="username" value="{{ old('email') }}" required autofocus>
                                <span class="icon is-small left"><i class="mdi mdi-account"></i></span>
                            </div>
                            <p class="help text-red-500">{{ $errors->first('email') }}</p>
                            <p class="help text-gray-600">
                                Please enter your Email
                            </p>
                        </div>
                        
                        <!-- Password -->
                        <div class="field spaced mb-4">
                            <label class="label font-medium">Password</label>
                            <div class="control icons-left">
                                <input class="input w-full p-2 border rounded" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                                <span class="icon is-small left"><i class="mdi mdi-asterisk"></i></span>
                            </div>
                            <p class="help text-red-500">{{ $errors->first('password') }}</p>
                            <p class="help text-gray-600">
                                Please enter your password
                            </p>
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="field spaced mb-4">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember">
                                    <span class="check"></span>
                                    <span class="control-label">Remember</span>
                                </label>
                            </div>
                        </div>
                        
                        <hr class="mb-4">
                        
                        <div class="field grouped flex justify-between">
                            <div class="control">
                            <button type="submit" class="button blue">
                                   Login
                            </button>
                            </div>
                            <div class="control">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="button text-blue-500 hover:text-blue-600">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>