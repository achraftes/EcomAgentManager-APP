@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Statistics for Agent: {{ $agent->name }}</h1>

        <h2>Total Leads: {{ $agent->leads_count }}</h2>
        <h2>Total Sales: {{ $agent->leads_sum_amount }}</h2>

        <h3>Daily Sales</h3>
        <ul>
            @foreach($dailySales as $sale)
                <li>{{ $sale->date }}: {{ $sale->total_sales }}</li>
            @endforeach
        </ul>

        <h3>Monthly Sales</h3>
        <ul>
            @foreach($monthlySales as $sale)
                <li>{{ $sale->month }}: {{ $sale->total_sales }}</li>
            @endforeach
        </ul>

        <h3>Sales by Address</h3>
        <ul>
            @foreach($addressSales as $sale)
                <li>{{ $sale->address }}: {{ $sale->total_sales }}</li>
            @endforeach
        </ul>
    </div>
@endsection
