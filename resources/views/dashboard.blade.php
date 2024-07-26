<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $clientsCount }}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ __('Clients') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $mediaBuyersCount }}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ __('Media Buyers') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $leadsCount }}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ __('Leads') }}</div>
                </div>
            </div>

            <!-- Recent Leads Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Recent Leads') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Order ID') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Client') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Amount') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Order Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $lead->order_id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $lead->client }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $lead->amount }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ \Carbon\Carbon::parse($lead->order_date)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $leads->links() }}
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Daily Sales') }}</h3>
                    <canvas id="dailySalesChart"></canvas>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Monthly Sales') }}</h3>
                    <canvas id="monthlySalesChart"></canvas>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Sales by Address') }}</h3>
                    <canvas id="addressSalesChart"></canvas>
                </div>
            </div>

            <!-- Best Media Buyers -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Best Media Buyers') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Media Buyer') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total Leads') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total Sales') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($bestMediaBuyers as $buyer)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $buyer->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $buyer->leads_count }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">{{ $buyer->leads_sum_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data for the charts
        const dailySalesData = @json($dailySales);
        const monthlySalesData = @json($monthlySales);
        const addressSalesData = @json($addressSales);

        // Process data for charts
        const processData = (data, label) => {
            return {
                labels: data.map(item => item.date || item.month || item.address),
                datasets: [{
                    label: label,
                    data: data.map(item => item.total_sales),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }],
            };
        };

        // Create charts
        const createChart = (ctx, type, data, options) => {
            return new Chart(ctx, {
                type: type,
                data: data,
                options: options,
            });
        };

        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        const dailySalesChart = createChart(dailySalesCtx, 'line', processData(dailySalesData, 'Daily Sales'), { scales: { y: { beginAtZero: true } } });

        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = createChart(monthlySalesCtx, 'bar', processData(monthlySalesData, 'Monthly Sales'), { scales: { y: { beginAtZero: true } } });

        const addressSalesCtx = document.getElementById('addressSalesChart').getContext('2d');
        const addressSalesChart = createChart(addressSalesCtx, 'pie', processData(addressSalesData, 'Sales by Address'), { responsive: true });
    });
</script>
@endpush
