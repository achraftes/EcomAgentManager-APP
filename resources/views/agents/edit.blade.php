@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">{{ __('Edit Agent') }}</h2>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- En-tête de la carte -->
                    <div class="bg-gray-100 px-4 py-3 border-b">
                        <h5 class="font-bold">{{ __('Edit Agent Information') }}</h5>
                    </div>
                    <!-- Corps de la carte -->
                    <div class="p-4">
                        <form action="{{ route('agents.update', $agent->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-bold mb-2">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" value="{{ $agent->name }}" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" value="{{ $agent->email }}" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 font-bold mb-2">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <!-- Boutons en bas de la carte -->
                            <div class="bg-gray-100 px-4 py-3 border-t">
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">{{ __('Update') }}</button>
                                    <a href="{{ route('agents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300 ml-2">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection