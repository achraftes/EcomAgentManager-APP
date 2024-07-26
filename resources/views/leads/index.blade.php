@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight">Leads Page</h2>
            @if (Auth::user()->role !== 'agent')
                <div class="flex space-x-2 items-center">
                    <a class="btn btn-primary bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 transition duration-300" href="{{ route('leads.create') }}">Import Leads</a>
                </div>
            @endif
        </div>
        <div class="mt-6">
            <form action="{{ route('leads.assign') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-gray-100 px-4 py-3 border-b">
                            <h5 class="font-bold">All Leads</h5>
                            <div class="flex space-x-2 items-center">
                                <input type="text" name="product" value="{{ request('product') }}" placeholder="Search Product" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Start Date" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="End Date" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Search</button>
                            </div>
                        </div>
                        <div class="p-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->role !== 'agent')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><input type="checkbox" id="select-all"></th>
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Method Payment</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($leads as $lead)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        @if (Auth::user()->role !== 'agent')
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="checkbox" name="leads[]" value="{{ $lead->id }}">
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $lead->order_id }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $lead->order_date }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $lead->product }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            <a class="text-indigo-600 hover:text-indigo-900">{{ $lead->client }}</a>
                                        </td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $lead->amount }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $lead->payment_method }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $lead->status }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            <a href="{{ route('leads.show', $lead->id) }}" class="bg-blue-400 text-white px-2 py-1 rounded-lg shadow-md hover:bg-blue-500 transition duration-300 inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM2.458 12C3.732 7.943 7.612 5 12 5c4.388 0 8.268 2.943 9.542 7-.274 1.07-1.272 2.072-2.317 2.318A8.986 8.986 0 0 1 12 19a8.986 8.986 0 0 1-7.225-3.682A6.997 6.997 0 0 1 2.458 12z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded-lg shadow-md hover:bg-yellow-500 transition duration-300 inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-lg shadow-md hover:bg-red-600 transition duration-300 inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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
                @if (Auth::user()->role !== 'agent')
                    <div class="mt-4 flex space-x-2 items-center">
                        <select name="agent_id" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled selected>Select Agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 transition duration-300">Assign Selected Leads</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if (Auth::user()->role !== 'agent')
        document.getElementById('select-all').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('input[name="leads[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
        });
    @endif

    function confirmDelete() {
        return confirm('Are you sure you want to delete this lead?');
    }
</script>
@endpush
@endsection
