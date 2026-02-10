<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['commande.user']);

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('datePaiement', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('datePaiement', '<=', $request->date_fin);
        }

        // Filtre par période prédéfinie
        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'aujourd_hui':
                    $query->whereDate('datePaiement', today());
                    break;
                case 'semaine':
                    $query->whereBetween('datePaiement', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'mois':
                    $query->whereMonth('datePaiement', now()->month)->whereYear('datePaiement', now()->year);
                    break;
            }
        }

        // Filtre par montant minimum/maximum
        if ($request->filled('montant_min')) {
            $query->where('montant', '>=', $request->montant_min);
        }
        if ($request->filled('montant_max')) {
            $query->where('montant', '<=', $request->montant_max);
        }

        // Recherche par numéro de commande ou nom client
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('commande', function ($q) use ($search) {
                $q->where('numSuivi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $paiements = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pages.paiement.list', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaiementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaiementRequest $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        //
    }
}
