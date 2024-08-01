<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            // Si l'utilisateur est un administrateur, afficher tous les clients
            $clients = Lead::all();
        } else {
            // Sinon, afficher uniquement les clients assignés à l'agent connecté
            $agentId = auth()->user()->agent->id;
            $clients = Lead::where('agent_id', $agentId)->get();
        }
    
        return view('clients.index', compact('clients'));
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:clients,email',
            'address' => 'required|string|max:255',
        ]);

        Client::create($request->all());

        return response()->json(['success' => 'Client added successfully.']);
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }


    public function clientsAss()
    {
        $user = Auth::user();

        if ($user && $user->role == 'agent') {
            $clients = Client::whereIn('full_name', function($query) use ($user) {
                $query->select('client')
                      ->from('leads')
                      ->where('agent_id', $user->agent->id);
            })->get();
        } else {
            $clients = collect();
        }

        return view('clients.index', compact('clients'));
    }
}
