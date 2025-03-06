@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold text-center mb-10">Reminders for {{ \Carbon\Carbon::now()->format('l j F Y') }}</h1>

        @php
            $today = \Carbon\Carbon::today()->format('Y-m-d');
        @endphp

        @if($leads->isEmpty())
            <!-- Section avec une grande image de fond qui couvre toute la largeur et la hauteur -->
            <div class="relative w-full h-screen overflow-hidden shadow-md">
                <img src="{{ asset('img/examples/exemple13.jpg') }}" alt="Background Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center">
                    <h2 class="text-5xl font-semibold text-yellow-500 mb-4">Oops! No Appointments Today 😟</h2>
                    <p  class="text-2xl text-white">There are no leads with "RDV le" status scheduled for today.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 ml-8">
                @foreach($leads as $lead)
                    @if(\Carbon\Carbon::parse($lead->comment)->format('Y-m-d') == $today)
                        <a href="{{ route('leads.show', $lead->id) }}" class="block bg-white p-6 rounded-lg shadow-md hover:bg-gray-50 transition duration-300">
                            <h2 class="text-xl font-semibold text-gray-800">RDV Le {{ \Carbon\Carbon::parse($lead->comment)->format('d F Y') }}</h2>
                            <p class="mt-4 text-gray-600">Client : {{ $lead->client }}</p>
                            <p class="mt-4 text-gray-600">Phone : {{ $lead->phone }}</p>
                            <p class="mt-4 text-gray-600">City : {{ $lead->city }}</p>
                            <p class="mt-4 text-gray-600">Address : {{ $lead->address }}</p>
                            <p class="mt-2 text-sm text-gray-400">Amount : ${{ $lead->amount }}</p>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection