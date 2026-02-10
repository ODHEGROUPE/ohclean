<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Services\ServiceKKiaPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Gère les webhooks KKiaPay
 *
 * KKiaPay envoie une notification quand:
 * - Le paiement est complété
 * - Le paiement a échoué
 * - Etc.
 */
class WebhookControleur extends Controller
{
    protected $serviceKKiaPay;

    public function __construct(ServiceKKiaPay $serviceKKiaPay)
    {
        $this->serviceKKiaPay = $serviceKKiaPay;
    }

    /**
     * Reçoit les notifications de KKiaPay
     * POST /webhook/kkiapay
     */
    public function gererWebhookKKiaPay(Request $request)
    {
        $donnees = $request->all();
        $signature = $request->header('X-Signature');

        // Vérifier la signature
        if (!$this->serviceKKiaPay->verifierSignatureWebhook($donnees, $signature)) {
            Log::warning('Webhook KKiaPay: Signature invalide!');
            return response()->json(['erreur' => 'Signature invalide'], 403);
        }

        $reference = $donnees['reference'] ?? null;
        $etat = $donnees['status'] ?? null;

        if (!$reference) {
            return response()->json(['erreur' => 'Référence manquante'], 400);
        }

        // Trouver l'abonnement
        $abonnement = Abonnement::where(
            'identifiant_transaction_kkpay',
            $reference
        )->first();

        if (!$abonnement) {
            Log::warning('Webhook KKiaPay: Abonnement non trouvé pour ' . $reference);
            return response()->json(['erreur' => 'Abonnement non trouvé'], 404);
        }

        // Traiter selon l'état
        if ($etat === 'completed') {
            $abonnement->update([
                'etat' => 'actif',
                'date_debut' => now(),
                'date_expiration' => now()->addDays($abonnement->duree_jours),
            ]);
            Log::info('Abonnement activé pour l\'utilisateur ' . $abonnement->utilisateur_id);
        } elseif ($etat === 'failed') {
            $abonnement->update(['etat' => 'echec']);
            Log::warning('Paiement échoué pour l\'abonnement ' . $abonnement->id);
        }

        return response()->json(['succes' => true]);
    }
}
