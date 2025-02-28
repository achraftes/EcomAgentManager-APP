@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">Media Buyers Page</h2>
            <div class="flex space-x-2 items-center">
                <a class="btn btn-secondary bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300" href="{{ route('mediaBuyers.create') }}">Add Media Buyer</a>
                <a class="btn btn-primary bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 transition duration-300" href="#" id="exportLeadBtn">Export Media Buyers File</a>
            </div>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-100 px-4 py-3 border-b">

                        <form method="GET" action="{{ route('mediaBuyers.index') }}" class="flex space-x-2 items-center">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Media Buyers" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Search</button>
                        </form>
                     <br>  <h5 class="font-bold">All Media Buyers</h5>
                    </div>
                    <div class="p-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MB ID</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($mediaBuyers as $mediaBuyer)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mediaBuyer->id }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $mediaBuyer->full_name }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $mediaBuyer->email }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @foreach ($mediaBuyer->products as $product)
                                            {{ $product->name }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $mediaBuyer->source }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('mediaBuyers.show', $mediaBuyer->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 inline-flex items-center">
                                            <i class="fas fa-eye mr-2"></i> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                              </svg>
                                              
                                        </a>
                                        <a href="{{ route('mediaBuyers.edit', $mediaBuyer->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded-lg shadow-md hover:bg-yellow-500 transition duration-300 inline-flex items-center">
                                            <i class="fas fa-edit mr-2"></i> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                              </svg>                                              
                                        </a>
                                        <form action="{{ route('mediaBuyers.destroy', $mediaBuyer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this media buyer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-lg shadow-md hover:bg-red-600 transition duration-300 inline-flex items-center">
                                                <i class="fas fa-trash-alt mr-2"></i> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                  </svg>
                                                  
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('exportLeadBtn').addEventListener('click', function() {
        alert('Export functionality is not implemented yet.');
    });
</script>
@endpush
@endsection
