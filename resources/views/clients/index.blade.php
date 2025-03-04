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
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM2.458 12C3.732 7.943 7.612 5 12 5c4.388 0 8.268 2.943 9.542 7-.274 1.07-1.272 2.072-2.317 2.318A8.986 8.986 0 0 1 12 19a8.986 8.986 0 0 1-7.225-3.682A6.997 6.997 0 0 1 2.458 12z" />
                                                    </svg>
                                                    </a>
                                                    {{-- Supprimer --}}
                                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client?');" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="button small red">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                  </svg>
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