@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight text-white">Edit Lead</h2><br>
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="address" name="address" value="{{ $lead->address }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="phone" name="phone" value="{{ $lead->phone }}" required>
                    </div>
                    @if (Auth::user()->role !== 'agent')
                    <div class="form-group">
                        <label for="agent_id" class="block text-sm font-medium text-gray-700">Agent</label>
                        <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="agent_id" name="agent_id" required>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $lead->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                    <div class="form-group">
                        <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="client" name="client" value="{{ $lead->client }}" required>
                    </div>
                    <div class="form-group">
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="city" name="city" value="{{ $lead->city }}" required>
                    </div>
                    <div class="form-group" hidden>
                        <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                        <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="product" name="product" value="{{ $lead->product }}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="amount" name="amount" value="{{ $lead->amount }}" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="px-2 py-1 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="non traite" {{ $lead->status == 'non traite' ? 'selected' : '' }}>Non Traite</option>
                            <option value="confirmed" {{ $lead->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="delivred" {{ $lead->status == 'delivred' ? 'selected' : '' }}>Delivred</option>
                            <option value="no response" {{ $lead->status == 'no response' ? 'selected' : '' }}>No Response</option>
                            <option value="canceled" {{ $lead->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            <option value="hors zone" {{ $lead->status == 'hors zone' ? 'selected' : '' }}>Hors Zone</option>
                            <option value="rdv" {{ $lead->status == 'rdv' ? 'selected' : '' }}>RDV le</option>
                            <option value="doublant" {{ $lead->status == 'doublant' ? 'selected' : '' }}>Doublant</option>
                            <option value="rappel" {{ $lead->status == 'rappel' ? 'selected' : '' }}>Rappel</option>
                            <option value="numero incorrect" {{ $lead->status == 'numero incorrect' ? 'selected' : '' }}>Numero Incorrect</option>
                            <option value="wtsp" {{ $lead->status == 'wtsp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="pas sur wtsp" {{ $lead->status == 'pas sur wtsp' ? 'selected' : '' }}>Pas sur WhatsApp</option>
                        </select>
                    </div>
                    <div class="form-group col-span-2">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="comment" name="comment">{{ $lead->comment }}</textarea>
                    </div>
                </div>
                <div class="form-group flex space-x-4">
                    <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Update Lead</button>
                    <a href="/leads" class="btn bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 transition duration-300">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
