@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-black">{{ __('Agent Details') }}</h2>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- En-tête de la carte -->
                    <div class="bg-gray-100 px-4 py-3 border-b">
                        <h5 class="font-bold">{{ __('Agent Information') }}</h5>
                    </div>
                    <!-- Corps de la carte -->
                    <div class="p-4">
                        <div class="mb-4 flex items-center">
                            <label class="block text-gray-700 font-bold mr-4">{{ __('Name :') }}</label>
                            <div class="flex items-center">
                                <p class="text-gray-900 mr-2">{{ $agent->name }}</p>
                                <button onclick="copyToClipboard('{{ $agent->name }}')" class="bg-transparent text-blue-500 hover:text-blue-600 p-1 rounded-full transition duration-300">
                                    <!-- Icon Copy Button -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="mb-4 flex items-center">
                            <label class="block text-gray-700 font-bold mr-4">{{ __('Email :') }}</label>
                            <div class="flex items-center">
                                <p class="text-gray-900 mr-2">{{ $agent->email }}</p>
                                <button onclick="copyToClipboard('{{ $agent->email }}')" class="bg-transparent text-blue-500 hover:text-blue-600 p-1 rounded-full transition duration-300">
                                    <!-- Icon Copy Button -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4 flex items-center">
                            <label class="block text-gray-700 font-bold mr-4">{{ __('Password :') }}</label>
                            <div class="flex items-center">
                                <!-- Password Field -->
                                <input type="password" id="password" class="text-gray-900 mr-2 p-2 border rounded-md" value="{{ $agent->password }}" readonly>
                                
                                <!-- Button to Show/Hide Password -->
                                <button onclick="togglePasswordVisibility()" class="bg-transparent text-blue-500 hover:text-blue-600 p-1 rounded-full transition duration-300">
                                    <!-- Icon for Show/Hide Password -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>

                                </button>

                                <!-- Button to Copy Password -->
                                <button onclick="copyToClipboard('{{ $agent->password }}')" class="bg-transparent text-blue-500 hover:text-blue-600 p-1 rounded-full transition duration-300 ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Boutons en bas de la carte -->
                    <div class="px-4 py-3 text-right bg-gray-100">
                        <a href="{{ route('agents.edit', $agent->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">{{ __('Edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const passwordType = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = passwordType;

        // Change icon to eye or eye-slash based on visibility
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordType === 'password') {
            eyeIcon.setAttribute('d', 'M9 5.25a6.75 6.75 0 0 1 6 0M9 5.25a6.75 6.75 0 0 0 0 13.5m6-13.5a6.75 6.75 0 0 1 0 13.5');
        } else {
            eyeIcon.setAttribute('d', 'M9 5.25a6.75 6.75 0 0 1 6 0M9 5.25a6.75 6.75 0 0 0 0 13.5m6 0a6.75 6.75 0 0 0-6-2.25');
        }
    }

    function copyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert("Text copied to clipboard!");
    }
</script>
@endsection
