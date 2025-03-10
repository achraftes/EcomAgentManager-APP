@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-semibold leading-tight text-black">Add Lead</h3>
        </div>
    </div>
    <div class="mt-6">
        <div class="overflow-x-auto">
            <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-100 px-4 py-3 border-b">
                    <h5 class="font-bold">Lead Details</h5>
                </div>
                <div class="p-4">
                    <form action="{{ route('leads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Other form fields -->
                            <div class="form-group">
                                <label for="mediaBuyer" class="block text-sm font-medium text-gray-700">Media Buyer</label>
                                <select id="mediaBuyer" name="media_buyer_id" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="" disabled selected>Select Media Buyer</option>
                                    @foreach($mediaBuyers as $mediaBuyer)
                                        <option value="{{ $mediaBuyer->id }}">{{ $mediaBuyer->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-span-2">
                                <label for="inputFile" class="block text-sm font-medium text-gray-700">Upload Excel File</label>
                                <input type="file" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="inputFile" name="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Save Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
