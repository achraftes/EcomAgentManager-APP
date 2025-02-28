@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">{{ __('Agent Details') }}</h2>
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
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">{{ __('Name') }}</label>
                            <div class="flex items-center">
                                <p class="text-gray-900">{{ $agent->name }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">{{ __('Email') }}</label>
                            <div class="flex items-center">
                                <p class="text-gray-900">{{ $agent->email }}</p>
                                <button onclick="copyToClipboard('{{ $agent->email }}')" class="bg-blue-500 text-white px-2 py-1 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">{{ __('Password') }}</label>
                            <div class="flex items-center">
                                <p class="text-gray-900">{{ $agent->password }}</p>
                                <button onclick="copyToClipboard('{{ $agent->password }}')" class="bg-blue-500 text-white px-2 py-1 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Boutons en bas de la carte -->
                    <div class="bg-gray-100 px-4 py-3 border-t">
                        <div class="flex justify-end">
                            <a href="{{ route('agents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Copied to clipboard');
    }, function(err) {
        alert('Failed to copy text: ', err);
    });
}
</script>
@endpush