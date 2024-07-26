<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead; // Assuming you have a Lead model
use App\Models\Sale; // Assuming you have a Sale model

class SalesController extends Controller
{
    public function getSalesData()
    {
        // Example data retrieval, adjust according to your database structure
        $dailySales = Lead::selectRaw('DATE(order_date) as date, SUM(amount) as total_sales')
                          ->groupBy('date')
                          ->get();

        $monthlySales = Lead::selectRaw('MONTH(order_date) as month, SUM(amount) as total_sales')
                            ->groupBy('month')
                            ->get();

        $addressSales = Lead::selectRaw('address, SUM(amount) as total_sales')
                            ->groupBy('address')
                            ->get();

        return response()->json([
            'dailySales' => $dailySales,
            'monthlySales' => $monthlySales,
            'addressSales' => $addressSales,
        ]);
    }
}