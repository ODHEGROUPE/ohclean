<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Service;
use App\Models\Commande;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LigneCommande;
use Illuminate\Http\RedirectResponse;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Commande::with('user');

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('dateCommande', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('dateCommande', '<=', $request->date_fin);
        }

        // Filtre par période prédéfinie
        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'aujourd_hui':
                    $query->whereDate('dateCommande', today());
                    break;
                case 'semaine':
                    $query->whereBetween('dateCommande', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'mois':
                    $query->whereMonth('dateCommande', now()->month)->whereYear('dateCommande', now()->year);
                    break;
            }
        }

        // Recherche par numéro de suivi ou nom client
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numSuivi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                         ->orWhere('telephone', 'like', "%{$search}%");
                  });
            });
        }

        $commandes = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pages.commande.list', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $users = User::where('role', 'CLIENT')->get();
        $services = Service::with('articles')->get();
        return view('admin.pages.commande.create', compact('users', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'dateLivraison' => 'nullable|date|after_or_equal:today',
            'lignes' => 'required|array|min:1',
            'lignes.*.article_id' => 'required|exists:articles,id',
            'lignes.*.quantite' => 'required|integer|min:1',
        ], [
            'user_id.required' => 'Le client est obligatoire',
            'user_id.exists' => 'Le client sélectionné n\'existe pas',
            'lignes.required' => 'Veuillez ajouter au moins un article',
            'lignes.min' => 'Veuillez ajouter au moins un article',
        ]);

        try {
            // Calculer le montant total
            $montantTotal = 0;
            foreach ($validated['lignes'] as $item) {
                $article = Article::find($item['article_id']);
                $montantTotal += $article->prix * $item['quantite'];
            }

            // Créer la commande
            $commande = Commande::create([
                'user_id' => $validated['user_id'],
                'dateCommande' => now()->toDateString(),
                'dateLivraison' => $validated['dateLivraison'],
                'statut' => 'EN_COURS', // Commandes créées par admin démarrent en cours
                'numSuivi' => 'CMD-' . strtoupper(Str::random(8)),
                'montantTotal' => $montantTotal,
            ]);

            // Créer les lignes de commande
            foreach ($validated['lignes'] as $item) {
                $article = Article::find($item['article_id']);

                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'article_id' => $item['article_id'],
                    'quantite' => $item['quantite'],
                    'prix' => $article->prix,
                ]);
            }

            return redirect()
                ->route('commandes.index')
                ->with('success', 'Commande créée avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la création: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande): View
    {
        $commande->load(['user', 'ligneCommandes.article.service', 'paiement']);
        return view('admin.pages.commande.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande): View
    {
        $users = User::where('role', 'CLIENT')->get();
        $services = Service::with('articles')->get();
        $commande->load('ligneCommandes.article.service');
        return view('admin.pages.commande.update', compact('commande', 'users', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'dateLivraison' => 'nullable|date',
            'statut' => 'required|in:EN_COURS,PRET,LIVREE,ANNULEE',
            'lignes' => 'required|array|min:1',
            'lignes.*.article_id' => 'required|exists:articles,id',
            'lignes.*.quantite' => 'required|integer|min:1',
        ], [
            'user_id.required' => 'Le client est obligatoire',
            'statut.required' => 'Le statut est obligatoire',
            'lignes.required' => 'Veuillez ajouter au moins un article',
        ]);

        try {
            // Calculer le montant total
            $montantTotal = 0;
            foreach ($validated['lignes'] as $item) {
                $article = Article::find($item['article_id']);
                $montantTotal += $article->prix * $item['quantite'];
            }

            // Mettre à jour la commande
            $commande->update([
                'user_id' => $validated['user_id'],
                'dateLivraison' => $validated['dateLivraison'],
                'statut' => $validated['statut'],
                'montantTotal' => $montantTotal,
            ]);

            // Supprimer les anciennes lignes et recréer
            $commande->ligneCommandes()->delete();

            foreach ($validated['lignes'] as $item) {
                $article = Article::find($item['article_id']);

                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'article_id' => $item['article_id'],
                    'quantite' => $item['quantite'],
                    'prix' => $article->prix,
                ]);
            }

            return redirect()
                ->route('commandes.index')
                ->with('success', 'Commande mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la mise à jour')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande): RedirectResponse
    {
        try {
            $commande->ligneCommandes()->delete();
            $commande->delete();

            return redirect()
                ->route('commandes.index')
                ->with('success', 'Commande supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la suppression');
        }
    }

    /**
     * Changer le statut d'une commande
     */
    public function changerStatut(Request $request, Commande $commande): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => 'required|in:EN_COURS,PRET,LIVREE,ANNULEE',
        ]);

        $commande->update(['statut' => $validated['statut']]);

        return redirect()
            ->back()
            ->with('success', 'Statut mis à jour avec succès');
    }

    /**
     * Imprimer une commande (facture)
     */
    public function imprimer(Commande $commande): View
    {
        $commande->load(['user', 'ligneCommandes.article.service', 'paiement']);
        return view('admin.pages.commande.print', compact('commande'));
    }
}
