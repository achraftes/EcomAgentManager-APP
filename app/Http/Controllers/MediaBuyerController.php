<?php

namespace App\Http\Controllers;

use App\Models\MediaBuyer;
use App\Models\Product;
use App\Models\Lead;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MediaBuyerController extends Controller
{
    public function index()
    {
        // Récupérer les Media Buyers avec leurs produits
        $mediaBuyers = MediaBuyer::with('products')->get();

        // Passer les Media Buyers à la vue
        return view('mediaBuyers.index', compact('mediaBuyers'));
    }

    public function create()
    {
        $products = Product::all(); // Assurez-vous d'avoir un modèle Product configuré correctement
        return view('mediaBuyers.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:media_buyers,email',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'source' => 'required|string|max:255',
        ]);

        // Création du Media Buyer
        $mediaBuyer = MediaBuyer::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'source' => $validatedData['source'],
        ]);

        // Attacher les produits au Media Buyer
        $mediaBuyer->products()->attach($validatedData['products']);

        // Rediriger avec un message de succès
        return redirect()->route('mediaBuyers.index')->with('success', 'Media Buyer created successfully.');
    }

    public function show(MediaBuyer $mediaBuyer)
    {
        $mediaBuyer->load('products');

        // Récupérer les leads associés au Media Buyer
        $leads = Lead::where('media_buyer_id', $mediaBuyer->id)->get();

        // Convertir order_date en Carbon instance
        $leads->each(function ($lead) {
            $lead->order_date = Carbon::parse($lead->order_date);
        });

        // Calculer les statistiques de ventes
        $salesStats = $leads->groupBy(function($lead) {
            return $lead->order_date->format('Y-m');
        })->map(function($leads) {
            return [
                'total_sales' => $leads->sum('amount'),
                'total_leads' => $leads->count(),
            ];
        });

        return view('mediaBuyers.show', compact('mediaBuyer', 'leads', 'salesStats'));
    }

    public function edit(MediaBuyer $mediaBuyer)
    {
        $products = Product::all(); // Récupérer tous les produits
        return view('mediaBuyers.edit', compact('mediaBuyer', 'products'));
    }

    public function update(Request $request, MediaBuyer $mediaBuyer)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:media_buyers,email,' . $mediaBuyer->id,
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'source' => 'required|string|max:255',
        ]);

        $mediaBuyer->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'source' => $request->source,
        ]);

        $mediaBuyer->products()->sync($request->products);

        return redirect()->route('mediaBuyers.index')->with('success', 'Media Buyer updated successfully.');
    }

    public function destroy(MediaBuyer $mediaBuyer)
    {
        $mediaBuyer->delete();

        return redirect()->route('mediaBuyers.index')->with('success', 'Media Buyer deleted successfully.');
    }
}
