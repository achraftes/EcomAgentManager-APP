<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Client;
use App\Models\Product;
use App\Models\Upsale;
use App\Models\MediaBuyer;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Imports\LeadsImport;
use App\Imports\LeadsCSVImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LeadController extends Controller
{


    public function index(Request $request)
    {
        $query = Lead::query();
    
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();
        if ($user) {
            if ($user->role == 'agent') {
                // Filtrer par agent si l'utilisateur est un agent
                $query->where('agent_id', $user->agent->id);
            }
        }
    
        // Appliquer les filtres de recherche
        if ($request->filled('product')) {
            $query->where('product', 'like', '%' . $request->product . '%');
        }
    
        if ($request->filled('start_date')) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
    
        if ($request->filled('end_date')) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }
    
        // Trier par date de création décroissante
        $query->orderBy('created_at', 'desc');
    
        // Récupérer les leads avec les clients associés
        $leads = $query->with('client')->get();
    
        $agents = Agent::all();
        $statuses = Lead::getStatuses();
    
        return view('leads.index', compact('leads', 'agents', 'statuses'));
    }
    
    

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|max:255',
    ]);

    $lead = Lead::findOrFail($id);
    $lead->status = $request->status;
    $lead->save();

    return redirect()->route('leads.index')->with('success', 'Lead status updated successfully');
}

    
public function updateComment(Request $request, $id)
{
    $request->validate([
        'comment' => 'nullable|string',
    ]);

    $lead = Lead::findOrFail($id);
    $lead->comment = $request->comment;
    $lead->save();

    return redirect()->route('leads.index')->with('success', 'Lead comment updated successfully');
}
    
public function create()
{
    $agents = Agent::all();
    $mediaBuyers = MediaBuyer::all(); // Récupérer tous les Media Buyers
    return view('leads.create', compact('agents', 'mediaBuyers'));
}

public function store(Request $request)
    {
        $request->validate([
            'file' => 'nullable|mimes:xlsx,xls',
            'media_buyer_id' => 'required|exists:media_buyers,id' // Ensure this validation exists
        ]);

        if ($request->hasFile('file')) {
            // Import data from the Excel file with the necessary argument
            try {
                Excel::import(new LeadsImport($request->media_buyer_id), $request->file('file'));

                return redirect()->route('leads.index')
                    ->with('success', 'Leads imported successfully from Excel file.');
            } catch (\Exception $e) {
                return redirect()->route('leads.index')
                    ->with('error', 'Error importing leads from Excel file: ' . $e->getMessage());
            }
        } else {
            // Create a new lead
            try {
                $lead = Lead::create($request->all());

                Client::updateOrCreate(
                    ['full_name' => $request->client],
                    [
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'address' => $request->address,
                    ]
                );

                return redirect()->route('leads.index')
                    ->with('success', 'Lead created successfully.');
            } catch (\Exception $e) {
                return redirect()->route('leads.index')
                    ->with('error', 'Error creating lead: ' . $e->getMessage());
            }
        }
    }



    public function show($id)
    {
        $lead = Lead::with(['upsales', 'agent'])->findOrFail($id);
        $agents = Agent::all();
        $products = Product::all();

        return view('leads.show', compact('lead', 'agents', 'products'));
    
    
    }


    public function updateshow(Request $request, $id)
    {
        // Récupérer le lead avec ses upsales
        $lead = Lead::with('upsales')->findOrFail($id);
    
        // Gérer les upsales
        $upsales = $request->input('products', []);
    
        // Supprimer les upsales existantes si elles ne sont pas présentes dans la requête
        $existingUpsaleIds = $lead->upsales->pluck('id')->toArray();
        $newUpsaleIds = array_filter(array_column($upsales, 'id'));
    
        $upsalesToDelete = array_diff($existingUpsaleIds, $newUpsaleIds);
        if (!empty($upsalesToDelete)) {
            Upsale::whereIn('id', $upsalesToDelete)->delete();
        }
    
        // Ajouter ou mettre à jour les upsales
        foreach ($upsales as $upsaleData) {
            if (isset($upsaleData['id'])) {
                // Mettre à jour l'upsale existante
                $upsale = Upsale::findOrFail($upsaleData['id']);
                $upsale->produit = $upsaleData['produit'];
                $upsale->prix = $upsaleData['prix'];
                $upsale->quantite = $upsaleData['quantite'];
                $upsale->save();
            } else {
                // Ajouter une nouvelle upsale
                $lead->upsales()->create([
                    'produit' => $upsaleData['produit'],
                    'prix' => $upsaleData['prix'],
                    'quantite' => $upsaleData['quantite'],
                ]);
            }
        }
    
        return redirect()->route('leads.index', $lead->id)->with('success', 'Upsales updated successfully');
    }
    





    public function edit(Lead $lead)
    {
        $agents = Agent::all();
        $products = Product::all();
        return view('leads.edit', compact('lead', 'agents', 'products'));
    }
    



    public function update(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|string|max:255',
            'order_date' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'agent_id' => 'required|exists:agents,id',
            'products.*.produit' => 'required|exists:products,id',
            'products.*.prix' => 'required|numeric',
            'products.*.quantite' => 'required|integer|min:1',
        ]);
    
        $lead = Lead::findOrFail($id);
    
        // Mettre à jour les informations du lead
        $lead->order_id = $request->order_id;
        $lead->order_date = $request->order_date;
        $lead->address = $request->address;
        $lead->phone = $request->phone;
        $lead->client = $request->client;
        $lead->amount = $request->amount;
        $lead->status = $request->status;
        $lead->comment = $request->comment;
        $lead->agent_id = $request->agent_id;
        $lead->save();
    
        // Ajouter les nouvelles upsales sans supprimer les existantes
        if ($request->has('products')) {
            foreach ($request->products as $product) {
                Log::info('Adding product to upsales', [
                    'lead_id' => $id,
                    'product_id' => $product['produit'],
                    'prix' => $product['prix'],
                    'quantite' => $product['quantite'],
                ]);
                $upsale = Upsale::create([
                    'lead_id' => $id,
                    'produit' => $product['produit'], // Changed from 'product_id' to 'produit'
                    'prix' => $product['prix'],
                    'quantite' => $product['quantite'],
                ]);
            }
        }
    
        return redirect()->route('leads.index')->with('success', 'Lead updated successfully');
    }
    

    
    

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }

    
    public function importForm()
    {
        $mediaBuyers = MediaBuyer::all();
        return view('leads.create');
    }

    public function importCSVForm()
    {
        $mediaBuyers = MediaBuyer::all();
        return view('leads.importCSVForm', compact('mediaBuyers'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
            'media_buyer_id' => 'required|exists:media_buyers,id'
        ]);

        Excel::import(new LeadsImport($request->media_buyer_id), $request->file('file'));

        return redirect()->route('leads.index')
            ->with('success', 'Leads imported successfully.');
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'media_buyer_id' => 'required|exists:media_buyers,id'
        ]);

        Excel::import(new LeadsCSVImport($request->media_buyer_id), $request->file('file'));

        return redirect()->route('leads.index')
            ->with('success', 'CSV imported successfully.');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'leads' => 'required|array',
            'leads.*' => 'exists:leads,id',
        ]);

        Lead::whereIn('id', $request->leads)->update(['agent_id' => $request->agent_id]);

        return redirect()->route('leads.index')->with('success', 'Leads assigned to agent successfully');
    }
    

}

