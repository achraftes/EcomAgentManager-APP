@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Edit Lead</h2><br>
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
            <form action="{{ route('leads.update', $lead->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Lead Details Fields -->
                    <div class="form-group">
                        <label for="order_id" class="block text-sm font-medium text-gray-700">Order ID</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="order_id" name="order_id" value="{{ $lead->order_id }}" required>
                    </div>
                    <div class="form-group">
                        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="order_date" name="order_date" value="{{ \Carbon\Carbon::parse($lead->order_date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="payment_method" name="payment_method" required>
                            <option value="paypal" {{ $lead->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="orange_money" {{ $lead->payment_method == 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                            <option value="cod" {{ $lead->payment_method == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="client" name="client" value="{{ $lead->client }}" required>
                    </div>
                    <div class="form-group" hidden>
                        <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="client" name="client" value="{{ $lead->product }}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="amount" name="amount" value="{{ $lead->amount }}" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="status" name="status" required>
                            <option value="active" {{ $lead->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="no response" {{ $lead->status == 'no response' ? 'selected' : '' }}>No Response</option>
                            <option value="canceled" {{ $lead->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <div class="form-group col-span-2">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="comment" name="comment" required>{{ $lead->comment }}</textarea>
                    </div>
                    @if (Auth::user()->role !== 'agent')
                    <div class="form-group col-span-2">
                        <label for="agent_id" class="block text-sm font-medium text-gray-700">Agent</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="agent_id" name="agent_id" required>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $lead->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
                </div>

                <!-- Static Table -->
                <div class="form-group">
                    <label>Static Products Table</label>
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="w-1/4 px-4 py-2">Produit</th>
                                <th class="w-1/4 px-4 py-2">Prix</th>
                                <th class="w-1/4 px-4 py-2">Quantité</th>
                                <th class="w-1/4 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2">
                                    <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[0][produit]" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[0][prix]" required>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[0][quantite]" required>
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600 transition duration-300" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-blue-500 text-white">
                            <tr>
                                <td colspan="2" class="text-right px-4 py-2"><strong>Total Price:</strong></td>
                                <td colspan="2" class="text-center px-4 py-2" id="total-price">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Update Lead</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let products = @json($products);

    function addRow() {
        const table = document.getElementById('products-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);
        const cell4 = newRow.insertCell(3);

        let productSelect = '<select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[][produit]" required>';
        products.forEach(product => {
            productSelect += `<option value="${product.id}">${product.name}</option>`;
        });
        productSelect += '</select>';

        cell1.innerHTML = productSelect;
        cell2.innerHTML = '<input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[][prix]" required oninput="calculateTotal()">';
        cell3.innerHTML = '<input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" name="products[][quantite]" required oninput="calculateTotal()">';
        cell4.innerHTML = '<button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600 transition duration-300" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i> Delete</button>';
    }

    function deleteRow(button) {
        const row = button.closest('tr');
        row.parentNode.removeChild(row);
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        const rows = document.querySelectorAll('#products-table tbody tr');
        rows.forEach(row => {
            const price = row.querySelector('input[name="products[][prix]"]').value;
            const quantity = row.querySelector('input[name="products[][quantite]"]').value;
            total += (price * quantity);
        });
        document.getElementById('total-price').innerText = total.toFixed(2);
    }
</script>
@endsection
