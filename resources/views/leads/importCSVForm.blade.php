@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h3 class="text-2xl font-semibold leading-tight">Import Leads from CSV</h3>
    </div>
    <div class="mt-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-4 py-3 border-b">
                <h5 class="font-bold">Import Leads from CSV</h5>
            </div>
            <div class="p-4">
                <form action="{{ route('leads.importCSV') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="form-group">
                        <label for="inputFile" class="block text-sm font-medium text-gray-700">Upload CSV File</label>
                        <input type="file" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="inputFile" name="file" required>
                    </div>
                    <div class="form-group">
                        <label for="media_buyer_id" class="block text-sm font-medium text-gray-700">Select Media Buyer</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="media_buyer_id" name="media_buyer_id" required>
                            <option value="" disabled selected>Select Media Buyer</option>
                            @foreach($mediaBuyers as $mediaBuyer)
                                <option value="{{ $mediaBuyer->id }}">{{ $mediaBuyer->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Import CSV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
