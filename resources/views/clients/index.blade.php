@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Clients</h2>

        @if($clients->isEmpty())
            <p>Aucun client n'est assigné à cet agent.</p>
        @else
            <div class="mt-6">
                <div class="overflow-x-auto">
                    <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-gray-100 px-4 py-3 border-b flex justify-between items-center">
                            <h5 class="font-bold">All Clients</h5>
                            <input type="text" id="searchInput" placeholder="Search Clients..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200" id="clientTable">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($clients as $client)
                                            <tr class="hover:bg-gray-50 transition duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $client->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $client->client }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $client->phone }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $client->address }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('clients.show', $client->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 inline-flex items-center">
                                                        <i class="fas fa-eye mr-2"></i> View
                                                    </a>
                                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-lg shadow-md hover:bg-red-600 transition duration-300 inline-flex items-center">
                                                            <i class="fas fa-trash-alt mr-2"></i> Delete
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
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchValue));
            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection
