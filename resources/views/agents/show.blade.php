@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-12">
        <h2 class="text-2xl font-semibold leading-tight">{{ __('Agent Details') }}</h2>
        <div class="mt-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $agent->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $agent->email }}</p>
                    <p class="text-gray-500 dark:text-gray-400">{{ $agent->password }}</p>
                </div>
                <a href="{{ route('agents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300">{{ __('Back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
