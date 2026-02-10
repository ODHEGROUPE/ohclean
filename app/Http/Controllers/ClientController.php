<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Article;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Page d'accueil
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Page À propos
     */
    public function about()
    {
        return view('client.pages.about');
    }

    /**
     * Page Services
     */
    public function services()
    {
        $services = Service::with('articles')->get();
        return view('client.pages.services', compact('services'));
    }

    /**
     * Page Commander
     */
    public function commander()
    {
        $services = Service::with(['articles' => function ($query) {
            $query->where('actif', true)->orderBy('nom');
        }])->get();

        return view('client.pages.commander', compact('services'));
    }

    /**
     * Traiter une commande client (formulaire classique)
     * La commande n'est créée qu'après le paiement réussi
     */
    public function storeCommande(Request $request)
    {
        // Filtrer les articles pour ne garder que ceux avec quantité > 0
        $articlesAvecQuantite = collect($request->articles ?? [])
            ->filter(fn($quantite) => $quantite > 0)
            ->toArray();

        // Remplacer les articles dans la requête
        $request->merge(['articles' => $articlesAvecQuantite]);

        // Déterminer si c'est une commande express
        $isExpress = $request->boolean('is_express');

        // Calculer la date minimum de livraison selon le mode
        $minDays = $isExpress ? 1 : 5;
        $minDateLivraison = now()->addDays($minDays)->format('Y-m-d');

        $request->validate([
            'articles' => 'required|array|min:1',
            'articles.*' => 'required|integer|min:1|max:99',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'date_recuperation' => 'required|date|after_or_equal:today',
            'lieu_recuperation' => 'required|string|max:255',
            'latitude_collecte' => 'nullable|numeric|between:-90,90',
            'longitude_collecte' => 'nullable|numeric|between:-180,180',
            'date_livraison' => ['required', 'date', 'after:date_recuperation', 'after_or_equal:' . $minDateLivraison],
            'heure_livraison' => 'required|string',
            'adresse_livraison' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'instructions' => 'nullable|string|max:1000',
        ], [
            'articles.required' => 'Veuillez sélectionner au moins un article',
            'articles.min' => 'Veuillez sélectionner au moins un article',
            'nom.required' => 'Le nom est obligatoire',
            'telephone.required' => 'Le téléphone est obligatoire',
            'date_recuperation.required' => 'La date de collecte est obligatoire',
            'lieu_recuperation.required' => 'Le lieu de collecte est obligatoire',
            'date_livraison.required' => 'La date de livraison est obligatoire',
            'date_livraison.after' => 'La date de livraison doit être après la date de collecte',
            'date_livraison.after_or_equal' => $isExpress
                ? 'La date de livraison doit être au moins demain (mode express)'
                : 'La date de livraison doit être dans au moins 5 jours',
            'heure_livraison.required' => 'L\'heure de livraison est obligatoire',
            'adresse_livraison.required' => 'L\'adresse de livraison est obligatoire',
        ]);

        try {
            // Calculer le total et préparer les lignes
            $total = 0;
            $lignes = [];

            foreach ($request->articles as $articleId => $quantite) {
                if ($quantite > 0) {
                    $article = Article::find($articleId);
                    if ($article) {
                        $sousTotal = $article->prix * $quantite;
                        $total += $sousTotal;
                        $lignes[] = [
                            'article_id' => $article->id,
                            'article_nom' => $article->nom,
                            'quantite' => $quantite,
                            'prix' => $article->prix,
                        ];
                    }
                }
            }

            if (empty($lignes)) {
                return back()->withErrors(['articles' => 'Veuillez sélectionner au moins un article avec une quantité supérieure à 0'])->withInput();
            }

            // Ajouter les frais express si applicable
            $fraisExpress = 0;
            if ($isExpress) {
                $fraisExpress = 2000;
                $total += $fraisExpress;
            }

            // Vérifier si l'utilisateur a un abonnement actif
            $hasAbonnement = false;
            if (auth()->check()) {
                $hasAbonnement = auth()->user()->abonnements()
                    ->where('etat', 'actif')
                    ->where('date_expiration', '>', now())
                    ->exists();
            }

            // Stocker les données en session (la commande sera créée après paiement)
            session(['commande_en_attente' => [
                'user_id' => auth()->check() ? auth()->id() : null,
                'nom' => $request->nom,
                'telephone' => $request->telephone,
                'date_recuperation' => $request->date_recuperation,
                'lieu_recuperation' => $request->lieu_recuperation,
                'latitude_collecte' => $request->latitude_collecte,
                'longitude_collecte' => $request->longitude_collecte,
                'date_livraison' => $request->date_livraison,
                'heure_livraison' => $request->heure_livraison,
                'adresse' => $request->adresse_livraison,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'instructions' => $request->instructions,
                'lignes' => $lignes,
                'montant' => $total,
                'frais_express' => $fraisExpress,
                'is_express' => $isExpress,
                'hasAbonnement' => $hasAbonnement,
            ]]);

            // Si abonné, créer la commande directement (pas de paiement nécessaire)
            if ($hasAbonnement) {
                return $this->creerCommandeDepuisSession();
            }

            // Sinon, rediriger vers la page de paiement
            return redirect()->route('client.paiement');

        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Créer la commande à partir des données en session
     */
    private function creerCommandeDepuisSession($transactionId = null)
    {
        $donneesCommande = session('commande_en_attente');

        if (!$donneesCommande) {
            return redirect()->route('commander')->with('error', 'Aucune commande en attente.');
        }

        try {
            DB::beginTransaction();

            // Vérifier si c'est une commande existante (paiement d'une commande non payée)
            if (isset($donneesCommande['commande_id'])) {
                $commande = Commande::find($donneesCommande['commande_id']);

                if (!$commande) {
                    return redirect()->route('client.commandes')->with('error', 'Commande introuvable.');
                }

                // Créer le paiement pour la commande existante
                if ($transactionId) {
                    \App\Models\Paiement::create([
                        'commande_id' => $commande->id,
                        'montant' => $donneesCommande['montant'],
                        'datePaiement' => now()->toDateString(),
                        'moyenPaiement' => 'MOBILE_MONEY',
                        'transaction_id' => $transactionId,
                    ]);
                }

                DB::commit();

                // Nettoyer la session
                session()->forget('commande_en_attente');

                return redirect()->route('client.commandes.show', $commande->id)
                    ->with('success', 'Paiement effectué avec succès !');
            }

            // Sinon, créer une nouvelle commande
            // Générer un numéro de suivi unique
            $numSuivi = 'CMD-' . strtoupper(Str::random(8));

            // Créer la commande
            $commande = Commande::create([
                'user_id' => $donneesCommande['user_id'],
                'dateCommande' => now()->toDateString(),
                'statut' => 'EN_COURS',
                'numSuivi' => $numSuivi,
                'montantTotal' => $donneesCommande['montant'],
                'date_recuperation' => $donneesCommande['date_recuperation'],
                'lieu_recuperation' => $donneesCommande['lieu_recuperation'],
                'latitude_collecte' => $donneesCommande['latitude_collecte'] ?? null,
                'longitude_collecte' => $donneesCommande['longitude_collecte'] ?? null,
                'dateLivraison' => $donneesCommande['date_livraison'],
                'heure_livraison' => $donneesCommande['heure_livraison'],
                'adresse_livraison' => $donneesCommande['adresse'],
                'latitude' => $donneesCommande['latitude'] ?? null,
                'longitude' => $donneesCommande['longitude'] ?? null,
                'instructions' => $donneesCommande['instructions'],
                'is_express' => $donneesCommande['is_express'] ?? false,
            ]);

            // Créer les lignes de commande
            foreach ($donneesCommande['lignes'] as $ligne) {
                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'article_id' => $ligne['article_id'],
                    'quantite' => $ligne['quantite'],
                    'prix' => $ligne['prix'],
                ]);
            }

            // Créer le paiement si transaction_id fourni (paiement KKiaPay)
            if ($transactionId) {
                \App\Models\Paiement::create([
                    'commande_id' => $commande->id,
                    'montant' => $donneesCommande['montant'],
                    'datePaiement' => now()->toDateString(),
                    'moyenPaiement' => 'MOBILE_MONEY',
                    'transaction_id' => $transactionId,
                ]);
            }

            DB::commit();

            // Nettoyer la session
            session()->forget('commande_en_attente');

            $message = $transactionId
                ? 'Paiement effectué et commande créée avec succès !'
                : 'Commande créée avec succès ! Couverte par votre abonnement.';

            return redirect()->route('client.commandes.confirmation', $commande->id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('commander')
                ->with('error', 'Une erreur est survenue lors de la création de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Page de paiement (affiche les données de session)
     */
    public function paiementPage()
    {
        $donneesCommande = session('commande_en_attente');

        if (!$donneesCommande) {
            return redirect()->route('commander')->with('error', 'Aucune commande en attente de paiement.');
        }

        $clePublique = config('kkpay.cle_publique');

        return view('client.pages.paiement-commande', [
            'donneesCommande' => $donneesCommande,
            'clePublique' => $clePublique,
        ]);
    }

    /**
     * Confirmation du paiement (callback KKiaPay) - Crée la commande
     */
    public function confirmationPaiement(Request $request)
    {
        $transactionId = $request->input('transaction_id');

        if (!$transactionId) {
            return redirect()->route('commander')->with('error', 'Transaction non valide.');
        }

        return $this->creerCommandeDepuisSession($transactionId);
    }

    /**
     * Page de confirmation de commande
     */
    public function confirmationCommande(Commande $commande)
    {
        $commande->load(['ligneCommandes.article']);

        return view('client.pages.confirmation-commande', compact('commande'));
    }

    /**
     * Page Contact
     */
    public function contact()
    {
        return view('client.pages.contact');
    }

    /**
     * Afficher les commandes du client connecté
     */
    public function mesCommandes()
    {
        $commandes = auth()->user()
            ->commandes()
            ->with(['ligneCommandes.article', 'paiement'])
            ->latest()
            ->paginate(10);

        return view('client.pages.mes-commandes', compact('commandes'));
    }

    /**
     * Afficher le détail d'une commande du client
     */
    public function voirCommande(Commande $commande)
    {
        // Vérifier que la commande appartient bien au client connecté
        if ($commande->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $commande->load(['ligneCommandes.article', 'paiement']);

        return view('client.pages.commande-detail', compact('commande'));
    }

    /**
     * Préparer le paiement d'une commande existante non payée
     */
    public function payerCommande(Commande $commande)
    {
        // Vérifier que la commande appartient bien au client connecté
        if ($commande->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier que la commande n'est pas déjà payée
        if ($commande->paiement) {
            return redirect()->route('client.commandes.show', $commande)
                ->with('info', 'Cette commande a déjà été payée.');
        }

        // Charger les lignes de commande
        $commande->load('ligneCommandes.article');

        // Préparer les données pour la session de paiement
        $lignes = [];
        foreach ($commande->ligneCommandes as $ligne) {
            $lignes[] = [
                'article_id' => $ligne->article_id,
                'article_nom' => $ligne->article->nom ?? 'Article',
                'quantite' => $ligne->quantite,
                'prix' => $ligne->prix,
            ];
        }

        // Stocker les données en session pour le paiement
        session(['commande_en_attente' => [
            'commande_id' => $commande->id, // ID de la commande existante
            'user_id' => $commande->user_id,
            'nom' => auth()->user()->name,
            'telephone' => auth()->user()->telephone ?? '',
            'date_recuperation' => $commande->date_recuperation,
            'lieu_recuperation' => $commande->lieu_recuperation ?? '',
            'latitude_collecte' => $commande->latitude_collecte,
            'longitude_collecte' => $commande->longitude_collecte,
            'date_livraison' => $commande->dateLivraison,
            'heure_livraison' => $commande->heure_livraison ?? '',
            'adresse' => $commande->adresse ?? '',
            'latitude' => $commande->latitude,
            'longitude' => $commande->longitude,
            'instructions' => $commande->instructions ?? '',
            'lignes' => $lignes,
            'montant' => $commande->montantTotal,
            'is_express' => $commande->is_express ?? false,
            'frais_express' => $commande->is_express ? 2000 : 0,
            'hasAbonnement' => false,
        ]]);

        return redirect()->route('client.paiement');
    }

    /**
     * Affiche le formulaire et le résultat du suivi de commande (sans compte)
     */
    public function suiviCommandeForm(Request $request)
    {
        $commande = null;
        $numero = $request->input('numero_commande');
        if ($numero) {
            $commande = \App\Models\Commande::where('numSuivi', $numero)
                ->with(['ligneCommandes.article'])
                ->first();
            if ($commande) {
                $commande->lignes = $commande->ligneCommandes->map(function($ligne) {
                    return [
                        'article_nom' => $ligne->article->nom ?? 'Article supprimé',
                        'quantite' => $ligne->quantite,
                    ];
                });
            }
        }
        return view('client.pages.suivi-commande', compact('commande'));
    }
}
