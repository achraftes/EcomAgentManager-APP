@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-12">
        <h2 class="text-2xl font-semibold leading-tight">{{ __('Select Agent') }}</h2>
        <div class="mt-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('agents.stats') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="agent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Select Agent') }}</label>
                        @if ($user->role === 'agent')
                            <select id="agent_id" name="agent_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" readonly>
                                <option value="{{ $user->agent->id }}">{{ $user->agent->name }}</option>
                            </select>
                        @else
                            <select id="agent_id" name="agent_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">{{ __('View Stats') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
