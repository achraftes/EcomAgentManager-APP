@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">Add Media Buyer</h2>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-100 px-4 py-3 border-b">
                        <h5 class="font-bold">New Media Buyer Form</h5>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('mediaBuyers.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="full_name" class="block text-gray-700 font-bold mb-2">Full Name</label>
                                <input type="text" class="form-control block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="full_name" name="full_name" placeholder="Enter Full Name" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="email" class="form-control block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="email" name="email" placeholder="Enter Email" required>
                            </div>
                            <div class="mb-4">
                                <label for="products" class="block text-gray-700 font-bold mb-2">Products</label>
                                <div id="product-fields">
                                    <div class="flex mb-2">
                                        <select class="form-control block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" name="products[]" required>
                                            <option value="" disabled selected>Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300" onclick="removeProductField(this)">Remove</button>
                                    </div>
                                </div>
                                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-300" onclick="addProductField()">Add Product</button>
                            </div>
                            <div class="mb-4">
                                <label for="source" class="block text-gray-700 font-bold mb-2">Source</label>
                                <input type="text" class="form-control block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="source" name="source" placeholder="Enter Source" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Submit</button>
                                <a href="{{ route('mediaBuyers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-300">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function addProductField() {
        const productFields = document.getElementById('product-fields');
        const div = document.createElement('div');
        div.className = 'flex mb-2';
        div.innerHTML = `
            <select class="form-control block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500" name="products[]" required>
                <option value="" disabled selected>Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <button type="button" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300" onclick="removeProductField(this)">Remove</button>
        `;
        productFields.appendChild(div);
    }

    function removeProductField(button) {
        const productField = button.closest('.flex');
        productField.remove();
    }
</script>
@endsection
