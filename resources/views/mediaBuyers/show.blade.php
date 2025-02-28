@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-white">Media Buyer Details</h2>
        </div>
        <div class="mt-6">
            <div class="overflow-x-auto">
                <div class="min-w-screen bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-blue-500 text-white px-4 py-3 border-b">
                        <h5 class="font-bold">{{ $mediaBuyer->full_name }}</h5>
                    </div>
                    <div class="p-4">
                        <p><strong>Email:</strong> {{ $mediaBuyer->email }}</p>
                        <p><strong>Source:</strong> {{ $mediaBuyer->source }}</p>
                        <p><strong>Products:</strong></p>
                        <ul class="list-disc list-inside">
                            @foreach($mediaBuyer->products as $product)
                                <li>{{ $product->name }}</li>
                            @endforeach
                        </ul>
                        <hr class="my-4">
                        <h4 class="text-lg font-bold">Leads</h4>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leads as $lead)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lead->order_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lead->order_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lead->client }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lead->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr class="my-4">
                        <h4 class="text-lg font-bold">Sales Statistics</h4>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sales</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Leads</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($salesStats as $month => $stats)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $month }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stats['total_sales'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $stats['total_leads'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr class="my-4">
                        <h4 class="text-lg font-bold">Sales Charts</h4>
                        <div class="charts-container flex justify-between flex-wrap">
                            <canvas id="dailySalesChart" class="flex-1 max-w-xs max-h-64 m-4"></canvas>
                            <canvas id="monthlySalesChart" class="flex-1 max-w-xs max-h-64 m-4"></canvas>
                            <canvas id="addressSalesChart" class="flex-1 max-w-xs max-h-64 m-4"></canvas>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('mediaBuyers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-300">Back</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    async function fetchSalesData() {
        const response = await fetch('/sales-data');
        const data = await response.json();
        return data;
    }

    function createChart(ctx, type, data, options) {
        return new Chart(ctx, {
            type: type,
            data: data,
            options: options,
        });
    }

    function processData(data) {
        const dailySalesData = {
            labels: data.dailySales.map(sale => sale.date),
            datasets: [{
                label: 'Daily Sales',
                data: data.dailySales.map(sale => sale.total_sales),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }],
        };

        const monthlySalesData = {
            labels: data.monthlySales.map(sale => sale.month),
            datasets: [{
                label: 'Monthly Sales',
                data: data.monthlySales.map(sale => sale.total_sales),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
            }],
        };

        const addressSalesData = {
            labels: data.addressSales.map(sale => sale.address),
            datasets: [{
                label: 'Sales by Address',
                data: data.addressSales.map(sale => sale.total_sales),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1,
            }],
        };

        return { dailySalesData, monthlySalesData, addressSalesData };
    }

    async function initCharts() {
        const data = await fetchSalesData();
        const { dailySalesData, monthlySalesData, addressSalesData } = processData(data);

        const dailySalesChartCtx = document.getElementById('dailySalesChart').getContext('2d');
        const monthlySalesChartCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const addressSalesChartCtx = document.getElementById('addressSalesChart').getContext('2d');

        createChart(dailySalesChartCtx, 'line', dailySalesData, {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#343a40'
                    }
                }
            }
        });

        createChart(monthlySalesChartCtx, 'bar', monthlySalesData, {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#343a40'
                    }
                }
            }
        });

        createChart(addressSalesChartCtx, 'pie', addressSalesData, {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#343a40'
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initCharts);
</script>
@endsection
