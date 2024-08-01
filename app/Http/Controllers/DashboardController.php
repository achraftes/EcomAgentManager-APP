<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MediaBuyer;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

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
    
        // Fetch agents
        $agents = Agent::all();
    
        return view('test.index', compact('clientsCount', 'mediaBuyersCount', 'leadsCount', 'totalSales', 'leads', 'dailySales', 'monthlySales', 'addressSales', 'bestMediaBuyers', 'agents'));
    }
    

    public function showAgentSelectionForm()
    {
        $user = Auth::user();
        $agents = [];

        if ($user->role !== 'agent') {
            $agents = Agent::all();
        }

        return view('agents.select', compact('agents', 'user'));
    }
    
    public function agentStats(Request $request)
    {
        $agentId = $request->input('agent_id');
    
        // Fetch agent specific data
        $agent = Agent::with(['leads' => function ($query) {
                $query->select('id', 'agent_id', 'order_id', 'amount', 'order_date', 'client', 'address', 'status');
            }])
            ->withCount('leads')
            ->withSum('leads', 'amount')
            ->findOrFail($agentId);
    
        // Fetch detailed sales data for the agent
        $dailySales = Lead::selectRaw('DATE(order_date) as date, SUM(amount) as total_sales')
                          ->where('agent_id', $agentId)
                          ->groupBy('date')
                          ->get()
                          ->toArray();
    
        $monthlySales = Lead::selectRaw('MONTH(order_date) as month, SUM(amount) as total_sales')
                            ->where('agent_id', $agentId)
                            ->groupBy('month')
                            ->get()
                            ->toArray();
    
        $addressSales = Lead::selectRaw('address, SUM(amount) as total_sales')
                            ->where('agent_id', $agentId)
                            ->groupBy('address')
                            ->get()
                            ->toArray();
    
        $statusCounts = Lead::selectRaw('status, COUNT(*) as count')
                            ->where('agent_id', $agentId)
                            ->groupBy('status')
                            ->get()
                            ->toArray();
    
        $leadsByStatus = Lead::where('agent_id', $agentId)
                            ->get()
                            ->groupBy('status');
    
        return view('agents.stats', compact('agent', 'dailySales', 'monthlySales', 'addressSales', 'statusCounts', 'leadsByStatus'));
    }
}
