@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-8">Statistics for Agent: <span class="text-blue-500">{{ $agent->name }}</span></h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="p-6 bg-blue-100 dark:bg-gray-700 rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Total Leads</h2>
                    <p class="text-4xl font-bold text-blue-600 dark:text-gray-300">{{ $agent->leads_count }}</p>
                </div>
                <div class="p-6 bg-green-100 dark:bg-gray-700 rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Total Sales</h2>
                    <p class="text-4xl font-bold text-green-600 dark:text-gray-300">$ {{ $agent->leads_sum_amount }}</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Daily Sales</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <canvas id="dailySalesChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Sales</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <canvas id="monthlySalesChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Sales by Address</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <canvas id="addressSalesChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Leads by Status</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <canvas id="statusChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Leads Details by Status</h3>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    @foreach($leadsByStatus as $status => $leads)
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $status }} ({{ $leads->count() }} leads)</h4>
                        <table class="min-w-full bg-white dark:bg-gray-800 mb-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">ID</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">Client</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-200">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leads as $lead)
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $lead->id }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $lead->client }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $lead->amount }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{  \Carbon\Carbon::parse($lead->order_date)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare data for daily sales chart
        var dailySalesData = @json($dailySales);
        var dailySalesLabels = dailySalesData.map(sale => sale.date);
        var dailySalesAmounts = dailySalesData.map(sale => sale.total_sales);

        // Prepare data for monthly sales chart
        var monthlySalesData = @json($monthlySales);
        var monthlySalesLabels = monthlySalesData.map(sale => sale.month);
        var monthlySalesAmounts = monthlySalesData.map(sale => sale.total_sales);

        // Prepare data for sales by address chart
        var addressSalesData = @json($addressSales);
        var addressSalesLabels = addressSalesData.map(sale => sale.address);
        var addressSalesAmounts = addressSalesData.map(sale => sale.total_sales);

        // Prepare data for status chart
        var statusData = @json($statusCounts);
        var statusLabels = statusData.map(status => status.status);
        var statusCounts = statusData.map(status => status.count);

        // Daily Sales Chart
        var ctxDaily = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: dailySalesLabels,
                datasets: [{
                    label: 'Daily Sales',
                    data: dailySalesAmounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Sales Chart
        var ctxMonthly = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: monthlySalesLabels,
                datasets: [{
                    label: 'Monthly Sales',
                    data: monthlySalesAmounts,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales by Address Chart
        var ctxAddress = document.getElementById('addressSalesChart').getContext('2d');
        new Chart(ctxAddress, {
            type: 'pie',
            data: {
                labels: addressSalesLabels,
                datasets: [{
                    label: 'Sales by Address',
                    data: addressSalesAmounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Leads by Status Chart
        var ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Leads by Status',
                    data: statusCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
