@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight text-black">Clients</h2>

        @if($clients->isEmpty())
            <p class="text-gray-500 text-center mt-4">Aucun client n'est assigné à cet agent.</p>
        @else
            <div class="mt-6">
                <div class="overflow-x-auto">
                    <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-gray-100 px-4 py-3 border-b flex justify-between items-center">
                        <p class="font-bold text-gray-800">
                         <span class="icon"><i class="mdi mdi-account-group"></i></span> 
                        All Clients
                        </p>
                            <input type="text" id="searchInput" placeholder="Search Clients..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="card-content">
                            <table >
                                <thead >
                                    <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Client ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Full Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Phone</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Address</th>
                                            
                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach($clients as $client)
                                        <tr >
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-700">{{ $client->client }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $client->address }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="buttons right nowrap">
                                                    {{-- Voir les détails --}}
                                                    <a href="{{ route('clients.show', $client->id) }}" class="button small blue">
                                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                                    </a>
                                                    {{-- Supprimer --}}
                                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client?');" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button small red">
                                                            <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            row.style.display = match ? '' : 'none';
        });
    });
</script>
@endpush
@endsection