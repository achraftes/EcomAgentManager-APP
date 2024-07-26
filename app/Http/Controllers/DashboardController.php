<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MediaBuyer;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data from the models
        $clientsCount = Client::count();
        $mediaBuyersCount = MediaBuyer::count();
        $leadsCount = Lead::count();
        $totalSales = Lead::sum('amount');
        $leads = Lead::orderBy('created_at', 'desc')->paginate(10);

        // Fetch detailed sales data for the charts
        $dailySales = Lead::selectRaw('DATE(order_date) as date, SUM(amount) as total_sales')
                          ->groupBy('date')
                          ->get();

        $monthlySales = Lead::selectRaw('MONTH(order_date) as month, SUM(amount) as total_sales')
                            ->groupBy('month')
                            ->get();

        $addressSales = Lead::selectRaw('address, SUM(amount) as total_sales')
                            ->groupBy('address')
                            ->get();

        // Fetch best media buyers with total leads and total sales
        $bestMediaBuyers = MediaBuyer::with(['leads' => function ($query) {
                $query->select('id', 'media_buyer_id', 'order_id', 'amount', 'order_date', 'client', 'address');
            }])
            ->withCount('leads')
            ->withSum('leads', 'amount')
            ->orderByDesc('leads_count')
            ->take(5)
            ->get();

        return view('test.index', compact('clientsCount', 'mediaBuyersCount', 'leadsCount', 'totalSales', 'leads', 'dailySales', 'monthlySales', 'addressSales', 'bestMediaBuyers'));
    }
}
