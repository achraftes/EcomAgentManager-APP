@extends('layouts.app')

@section('content')
<section class="section main-section">
    <!-- Titre -->
    <h1 class="text-3xl font-bold text-gray-800 ">Statistics for Agent : <span class="text-blue-500">{{ $agent->name }}</span></h1>

    <!-- Cards statistiques -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 mb-6">
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>Total Leads</h3>
                        <h1>{{ $agent->leads_count }}</h1>
                    </div>
                    <span class="icon widget-icon text-blue-500"><i class="mdi mdi-chart-line mdi-48px"></i></span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>Total Sales</h3>
                        <h1>${{ $agent->leads_sum_amount }}</h1>
                    </div>
                    <span class="icon widget-icon text-green-500"><i class="mdi mdi-finance mdi-48px"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 mb-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-chart-line"></i></span>
                    Daily Sales
                </p>
            </header>
            <div class="card-content">
                <canvas id="dailySalesChart"></canvas>
            </div>
        </div>

        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-chart-bar"></i></span>
                    Monthly Sales
                </p>
            </header>
            <div class="card-content">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 mb-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-chart-pie"></i></span>
                    Sales by Address
                </p>
            </header>
            <div class="card-content">
                <canvas id="addressSalesChart"></canvas>
            </div>
        </div>

        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-chart-donut"></i></span>
                    Leads by Status
                </p>
            </header>
            <div class="card-content">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau des leads détaillés par statut -->
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                Leads Details by Status
            </p>
        </header>
        <div class="card-content">
            @foreach($leadsByStatus as $status => $leads)
            <h4 class="text-lg font-semibold text-gray-200 dark:text-gray-800 mb-4">{{ $status }} ({{ $leads->count() }} leads)</h4>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->client }}</td>
                                <td>${{ $lead->amount }}</td>
                                <td>{{ \Carbon\Carbon::parse($lead->order_date)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- <hr class="my-4"> -->
            @endforeach
        </div>
    </div>
</section>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données pour les graphiques
    const dailySalesData = @json($dailySales);
    const monthlySalesData = @json($monthlySales);
    const addressSalesData = @json($addressSales);
    const statusData = @json($statusCounts);

    // Fonction pour créer un graphique
    const createChart = (ctx, type, data, options) => {
        return new Chart(ctx, {
            type: type,
            data: data,
            options: options,
        });
    };

    // Graphique des ventes quotidiennes
    const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
    createChart(dailySalesCtx, 'line', {
        labels: dailySalesData.map(sale => sale.date),
        datasets: [{
            label: 'Daily Sales',
            data: dailySalesData.map(sale => sale.total_sales),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 1
        }]
    }, {
        scales: { y: { beginAtZero: true } },
        responsive: true,
        maintainAspectRatio: false
    });

    // Graphique des ventes mensuelles
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    createChart(monthlySalesCtx, 'bar', {
        labels: monthlySalesData.map(sale => sale.month),
        datasets: [{
            label: 'Monthly Sales',
            data: monthlySalesData.map(sale => sale.total_sales),
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    }, {
        scales: { y: { beginAtZero: true } },
        responsive: true,
        maintainAspectRatio: false
    });

    // Graphique des ventes par adresse
    const addressSalesCtx = document.getElementById('addressSalesChart').getContext('2d');
    createChart(addressSalesCtx, 'pie', {
        labels: addressSalesData.map(sale => sale.address),
        datasets: [{
            label: 'Sales by Address',
            data: addressSalesData.map(sale => sale.total_sales),
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
    }, {
        responsive: true,
        maintainAspectRatio: false
    });

    // Graphique des leads par statut
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    createChart(statusCtx, 'doughnut', {
        labels: statusData.map(status => status.status),
        datasets: [{
            label: 'Leads by Status',
            data: statusData.map(status => status.count),
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
    }, {
        responsive: true,
        maintainAspectRatio: false
    });
});
</script>
@endpush
@endsection