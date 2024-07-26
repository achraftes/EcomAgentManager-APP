@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold text-center text-blue-500 mb-6">Client Details</h2>
        <div class="bg-white p-6 rounded-lg shadow-lg mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-semibold">Full Name</h3>
                    <p class="text-gray-700">{{ $client->full_name }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Phone</h3>
                    <p class="text-gray-700">{{ $client->phone }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Email</h3>
                    <p class="text-gray-700">{{ $client->email }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Address</h3>
                    <p class="text-gray-700">{{ $client->address }}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('clients.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Back to Clients</a>
            </div>
        </div>
    </div>
</div>
@endsection
