@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-12">
        <h2 class="text-3xl font-semibold leading-tight text-white"">{{ __('Admin / Dashboard') }}</h2>
    </div>
</div>

<section class="section main-section">
    <!-- Cards statistiques -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-4 mb-6">
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>Clients</h3>
              <h1>{{ $clientsCount }}</h1>
            </div>
            <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
          </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>Media Buyers</h3>
              <h1>{{ $mediaBuyersCount }}</h1>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-account-check mdi-48px"></i></span>
          </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>Leads</h3>
              <h1>{{ $leadsCount }}</h1>
            </div>
            <span class="icon widget-icon text-purple-500"><i class="mdi mdi-lead-pencil mdi-48px"></i></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>Total Sales</h3>
              <h1>${{ $totalSales }}</h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Graphique de performance -->
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-finance"></i></span>
          Performance
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand"><div></div></div>
              <div class="chartjs-size-monitor-shrink"><div></div></div>
            </div>
            <canvas id="big-line-chart" width="2992" height="1000" class="chartjs-render-monitor block" style="height: 400px; width: 1197px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Section graphiques -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
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
    </div>

    <div class="notification blue">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-buffer"></i></span>
          <b>Recent Leads Table</b>
        </div>
        <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
      </div>
    </div>

    <!-- Tableau des leads récents -->
    <div class="card has-table mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Recent Leads
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Order ID</th>
              <th>Client</th>
              <th>Amount</th>
              <th>Order Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($leads as $lead)
            <tr>
              <td class="image-cell">
                <div class="image">
                  <img src="https://avatars.dicebear.com/v2/initials/{{ strtolower(substr($lead->client, 0, 2)) }}.svg" class="rounded-full">
                </div>
              </td>
              <td data-label="Order ID">{{ $lead->order_id }}</td>
              <td data-label="Client">{{ $lead->client }}</td>
              <td data-label="Amount">${{ $lead->amount }}</td>
              <td data-label="Order Date">
                <small class="text-gray-500" title="{{ \Carbon\Carbon::parse($lead->order_date)->format('M d, Y') }}">
                  {{ \Carbon\Carbon::parse($lead->order_date)->format('M d, Y') }}
                </small>
              </td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <button class="button small green --jb-modal" data-target="sample-modal-2" type="button">
                    <span class="icon"><i class="mdi mdi-eye"></i></span>
                  </button>
                  <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                    <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="table-pagination">
          <div class="flex items-center justify-between">
            {{ $leads->links() }}
          </div>
        </div>
      </div>
    </div>

    <!-- Tableau des meilleurs Media Buyers -->
    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-star"></i></span>
          Best Media Buyers
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Media Buyer</th>
              <th>Total Leads</th>
              <th>Total Sales</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bestMediaBuyers as $buyer)
            <tr>
              <td class="image-cell">
                <div class="image">
                  <img src="https://avatars.dicebear.com/v2/initials/{{ strtolower(substr($buyer->full_name, 0, 2)) }}.svg" class="rounded-full">
                </div>
              </td>
              <td data-label="Media Buyer">{{ $buyer->full_name }}</td>
              <td data-label="Total Leads">{{ $buyer->leads_count }}</td>
              <td data-label="Total Sales">$ {{ $buyer->leads_sum_amount }}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('mediaBuyers.show', $buyer->id) }}" class="button small blue">
                    <span class="icon"><i class="mdi mdi-eye"></i></span>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection


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

    // Daily Sales Chart
    const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
    const dailySalesChart = createChart(dailySalesCtx, 'line', processData(dailySalesData, 'Daily Sales'), { 
        scales: { y: { beginAtZero: true } },
        responsive: true,
        maintainAspectRatio: false
    });

    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesChart = createChart(monthlySalesCtx, 'bar', processData(monthlySalesData, 'Monthly Sales'), { 
        scales: { y: { beginAtZero: true } },
        responsive: true,
        maintainAspectRatio: false
    });

    // Address Sales Chart
    const addressSalesCtx = document.getElementById('addressSalesChart').getContext('2d');
    const addressSalesChart = createChart(addressSalesCtx, 'pie', processData(addressSalesData, 'Sales by Address'), { 
        responsive: true,
        maintainAspectRatio: false
    });
    
    // Big Line Chart 
    if (document.getElementById('big-line-chart')) {
        const bigLineCtx = document.getElementById('big-line-chart').getContext('2d');
        const combinedData = {
            labels: dailySalesData.map(item => item.date),
            datasets: [{
                label: 'Sales',
                data: dailySalesData.map(item => item.total_sales),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        };
        
        const bigLineChart = new Chart(bigLineCtx, {
            type: 'line',
            data: combinedData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                }
            }
        });
    }
});
</script>
@endpush