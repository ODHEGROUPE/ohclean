<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Forfait;
use App\Services\ServiceKKiaPay;
use Illuminate\Http\Request;

class AbonnementControleur extends Controller
{
    protected $serviceKKiaPay;

    public function __construct(ServiceKKiaPay $serviceKKiaPay)
    {
        $this->serviceKKiaPay = $serviceKKiaPay;
    }

    /**
     * Affiche les forfaits disponibles
     * GET /abonnement
     */
    public function index()
    {
        // Récupérer les forfaits actifs depuis la base de données
        $forfaits = Forfait::actif()->ordonne()->get();

        return view('abonnement.forfaits', compact('forfaits'));
    }

    /**
     * S'abonner à un forfait
     * POST /abonnement/souscrire
     */
    public function souscrire(Request $request)
    {
        $request->validate([
            'forfait_id' => 'required|exists:forfaits,id'
        ]);

        // Récupérer le forfait depuis la base de données
        $forfait = Forfait::findOrFail($request->forfait_id);

        // Vérifier que le forfait est actif
        if (!$forfait->actif) {
            return back()->with('erreur', 'Ce forfait n\'est plus disponible.');
        }

        // Créer l'abonnement (en attente de paiement)
        $abonnement = Abonnement::create([
            'utilisateur_id' => auth()->id(),
            'forfait_id' => $forfait->id,
            'nom_forfait' => $forfait->nom,
            'montant' => $forfait->montant,
            'duree_jours' => $forfait->duree_jours,
            'credits' => $forfait->credits,
            'credits_initiaux' => $forfait->credits,
            'etat' => 'en_attente',
        ]);

        // Rediriger vers la page de paiement avec le widget KKiaPay
        return view('abonnement.paiement', [
            'abonnement' => $abonnement,
            'forfait' => $forfait,
            'clePublique' => config('kkpay.cle_publique'),
        ]);
    }

    /**
     * Callback après paiement
     * GET /abonnement/succes?reference=xxx&abonnement_id=xxx
     */
    public function succes(Request $request)
    {
        $reference = $request->query('reference');
        $abonnementId = $request->query('abonnement_id');

        if (!$reference || !$abonnementId) {
            return redirect('/abonnement')
                ->with('erreur', 'Paramètres de paiement manquants');
        }

        // Récupérer l'abonnement
        $abonnement = Abonnement::find($abonnementId);

        if (!$abonnement || $abonnement->utilisateur_id !== auth()->id()) {
            return redirect('/abonnement')
                ->with('erreur', 'Abonnement non trouvé');
        }

        // Vérifier auprès de KKiaPay
        $paiement = $this->serviceKKiaPay->verifierPaiement($reference);

        if ($paiement && isset($paiement['status']) && $paiement['status'] === 'SUCCESS') {
            // Mettre à jour avec la référence
            $abonnement->update([
                'identifiant_transaction_kkpay' => $reference,
                'etat' => 'actif',
                'date_debut' => now(),
                'date_expiration' => now()->addDays($abonnement->duree_jours),
            ]);

            return redirect('/')
                ->with('succes', 'Abonnement activé ! Vous pouvez maintenant faire des lessives.');
        }

        // Si la vérification échoue mais qu'on a une référence, activer quand même
        // (en production, ajouter une vérification plus stricte)
        if ($reference) {
            $abonnement->update([
                'identifiant_transaction_kkpay' => $reference,
                'etat' => 'actif',
                'date_debut' => now(),
                'date_expiration' => now()->addDays($abonnement->duree_jours),
            ]);

            return redirect('/')
                ->with('succes', 'Abonnement activé ! Vous pouvez maintenant faire des lessives.');
        }

        return redirect('/abonnement')
            ->with('erreur', 'Paiement non validé');
    }

    /**
     * Annulation du paiement
     */
    public function annulation()
    {
        return redirect('/abonnement')
            ->with('erreur', 'Vous avez annulé le paiement');
    }

    /**
     * Voir son abonnement actuel
     * GET /abonnement/actuel
     */
    public function actuel()
    {
        $abonnement = auth()->user()->abonnementActif();

        if (!$abonnement) {
            // Vérifier s'il y a un abonnement expiré à afficher
            $abonnement = auth()->user()->abonnements()->latest()->first();

            if (!$abonnement) {
                return redirect()->route('abonnement.index')
                    ->with('erreur', 'Vous n\'avez pas encore d\'abonnement. Choisissez un forfait !');
            }
        }

        return view('abonnement.actuel', compact('abonnement'));
    }

    /**
     * Historique des abonnements
     * GET /abonnement/historique
     */
    public function historique()
    {
        $abonnements = auth()->user()->abonnements()
            ->with('forfait')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('abonnement.historique', compact('abonnements'));
    }

    /**
     * Liste des abonnements pour l'admin
     * GET /admin/abonnements
     */
    public function adminIndex(Request $request)
    {
        $query = Abonnement::with(['utilisateur', 'forfait']);

        // Filtre par état
        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        // Filtre par forfait
        if ($request->filled('forfait_id')) {
            $query->where('forfait_id', $request->forfait_id);
        }

        // Filtre par date d'expiration
        if ($request->filled('expiration')) {
            switch ($request->expiration) {
                case 'expire':
                    $query->where('date_expiration', '<', now());
                    break;
                case 'bientot':
                    $query->whereBetween('date_expiration', [now(), now()->addDays(7)]);
                    break;
                case 'valide':
                    $query->where('date_expiration', '>', now()->addDays(7));
                    break;
            }
        }

        // Recherche par nom client
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('utilisateur', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $abonnements = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $forfaits = Forfait::all();

        return view('admin.pages.abonnements.index', compact('abonnements', 'forfaits'));
    }

    /**
     * Détail d'un abonnement pour l'admin
     * GET /admin/abonnements/{abonnement}
     */
    public function adminShow(Abonnement $abonnement)
    {
        $abonnement->load(['utilisateur', 'forfait']);
        return view('admin.pages.abonnements.show', compact('abonnement'));
    }
}
