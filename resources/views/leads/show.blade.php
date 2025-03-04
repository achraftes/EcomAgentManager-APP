@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight text-black">Lead Details</h2><br>
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
            <form action="{{ route('leads.updateshow', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Lead Details Fields -->
                    <div class="form-group">
                        <label for="order_id" class="block text-sm font-medium text-gray-700">Order ID</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="order_id" name="order_id" value="{{ $lead->order_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                        <input type="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="order_date" name="order_date" value="{{ \Carbon\Carbon::parse($lead->order_date)->format('Y-m-d') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="payment_method" name="payment_method" disabled>
                            <option value="paypal" {{ $lead->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="orange_money" {{ $lead->payment_method == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                            <option value="cod" {{ $lead->payment_method == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="client" name="client" value="{{ $lead->client }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="amount" name="amount" value="{{ $lead->amount }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="status" name="status" disabled>
                            <option value="active" {{ $lead->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="no response" {{ $lead->status == 'no response' ? 'selected' : '' }}>No Response</option>
                            <option value="canceled" {{ $lead->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <div class="form-group col-span-2">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="comment" name="comment" readonly>{{ $lead->comment }}</textarea>
                    </div>
                    @if (Auth::user()->role !== 'agent')
                    <div class="form-group col-span-2">
                        <label for="agent_id" class="block text-sm font-medium text-gray-700">Agent</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="agent_id" name="agent_id" disabled>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $lead->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Products Table --><br>
                <div class="form-group">
                    <label>Upsales</label>
                    <table id="products-table" class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="w-1/4 px-4 py-2">Produit</th>
                                <th class="w-1/4 px-4 py-2">Prix</th>
                                <th class="w-1/4 px-4 py-2">Quantité</th>
                                <th class="w-1/4 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lead->upsales as $index => $upsale)
                            <tr>
                                <td class="px-4 py-2">
                                    <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[{{ $index }}][produit]">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $upsale->produit == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[{{ $index }}][prix]" value="{{ $upsale->prix }}">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[{{ $index }}][quantite]" value="{{ $upsale->quantite }}">
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300" onclick="removeProductRow(this)">Supprimer</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-300" onclick="addProductRow()">Ajouter un produit</button>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Enregistrer</button>
                    <a href="{{ route('leads.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-300">Back to Leads</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addProductRow() {
        var table = document.getElementById('products-table').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();
        var rowCount = table.rows.length;
        newRow.innerHTML = `
            <td class="px-4 py-2">
                <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[new_${rowCount}][produit]">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="px-4 py-2">
                <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[new_${rowCount}][prix]" value="">
            </td>
            <td class="px-4 py-2">
                <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[new_${rowCount}][quantite]" value="">
            </td>
            <td class="px-4 py-2">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300" onclick="removeProductRow(this)">Supprimer</button>
            </td>
        `;
    }

    function removeProductRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection
