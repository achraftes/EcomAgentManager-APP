<?php
namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\WelcomeAgent;

class AgentController extends Controller
{
    public function index()
{
    $agents = Agent::orderBy('created_at', 'desc')->get();
    return view('agents.index', compact('agents'));
}


    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Récupérer le mot de passe en clair
        $password = $request->password;
    
        // Créer l'utilisateur avec le mot de passe haché
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'agent',
        ]);
    
        // Créer l'agent en enregistrant le mot de passe non haché
        $agent = Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password, // Mot de passe non haché
            'user_id' => $user->id, // Utilisez l'ID de l'utilisateur ici
        ]);
    
        // Envoyer l'email de bienvenue avec le mot de passe
        $user->notify(new WelcomeAgent($password));
    
        return redirect()->route('agents.index')->with('success', 'Agent created successfully and welcome email sent.');
    }
    
    

    public function show(Agent $agent)
    {
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents,email,' . $agent->id . '|unique:users,email,' . $agent->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $agent->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? $request->password : $agent->password,
        ]);

        $user = User::where('email', $agent->email)->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => 'agent',
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(Agent $agent)
    {
        $user = User::where('email', $agent->email)->first();
        if ($user) {
            $user->delete();
        }

        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }
    public function home()
    {
        $user = Auth::user();
        $agent = $user->agent;
        $today = \Carbon\Carbon::today();
    
        $leads = Lead::whereDate('comment', $today)
                    ->where('agent_id', $agent->id)
                    ->whereNotNull('comment')
                    ->where('status', 'rdv')
                    ->get();
    
        return view('test.home', compact('leads'));
    }

}
