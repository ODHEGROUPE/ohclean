<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForfaitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Forfait::query();

        // Filtre par statut actif
        if ($request->filled('actif')) {
            $query->where('actif', $request->actif === '1');
        }

        // Filtre par popularité
        if ($request->filled('est_populaire')) {
            $query->where('est_populaire', $request->est_populaire === '1');
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', "%{$request->search}%");
        }

        // Filtre par prix
        if ($request->filled('prix_min')) {
            $query->where('montant', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('montant', '<=', $request->prix_max);
        }

        $forfaits = $query->ordonne()->get();
        return view('admin.pages.forfaits.index', compact('forfaits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.forfaits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|integer|min:0',
            'duree_jours' => 'required|integer|min:1',
            'credits' => 'required|integer|min:1',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*' => 'string',
            'est_populaire' => 'boolean',
            'actif' => 'boolean',
            'ordre' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['est_populaire'] = $request->has('est_populaire');
        $validated['actif'] = $request->has('actif');
        $validated['caracteristiques'] = array_filter($validated['caracteristiques'] ?? []);

        Forfait::create($validated);

        return redirect()->route('admin.forfaits.index')
            ->with('success', 'Forfait créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Forfait $forfait)
    {
        return view('admin.pages.forfaits.show', compact('forfait'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forfait $forfait)
    {
        return view('admin.pages.forfaits.edit', compact('forfait'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forfait $forfait)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|integer|min:0',
            'duree_jours' => 'required|integer|min:1',
            'credits' => 'required|integer|min:1',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*' => 'string',
            'est_populaire' => 'boolean',
            'actif' => 'boolean',
            'ordre' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['est_populaire'] = $request->has('est_populaire');
        $validated['actif'] = $request->has('actif');
        $validated['caracteristiques'] = array_filter($validated['caracteristiques'] ?? []);

        $forfait->update($validated);

        return redirect()->route('admin.forfaits.index')
            ->with('success', 'Forfait mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forfait $forfait)
    {
        // Vérifier si des abonnements utilisent ce forfait
        if ($forfait->abonnements()->count() > 0) {
            return back()->with('error', 'Ce forfait ne peut pas être supprimé car il est utilisé par des abonnements.');
        }

        $forfait->delete();

        return redirect()->route('admin.forfaits.index')
            ->with('success', 'Forfait supprimé avec succès.');
    }
}
