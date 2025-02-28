@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">{{ __('Select Agent') }}</h2>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- En-tête de la carte -->
                    <div class="bg-gray-100 px-4 py-3 border-b">
                        <h5 class="font-bold">{{ __('Select Agent to View Stats') }}</h5>
                    </div>
                    <!-- Corps de la carte -->
                    <div class="p-4">
                        <form action="{{ route('agents.stats') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="agent_id" class="block text-gray-700 font-bold mb-2">{{ __('Select Agent') }}</label>
                                @if ($user->role === 'agent')
                                    <select id="agent_id" name="agent_id" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" readonly>
                                        <option value="{{ $user->agent->id }}">{{ $user->agent->name }}</option>
                                    </select>
                                @else
                                    <select id="agent_id" name="agent_id" class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <!-- Boutons en bas de la carte -->
                            <div class="bg-gray-100 px-4 py-3 border-t">
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">{{ __('View Stats') }}</button>
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