<?php

namespace App\Services;

use App\Models\Abonnement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service pour gérer les paiements KKiaPay
 *
 * KKiaPay accepte:
 * - MTN Mobile Money
 * - Moov Money
 * - Cartes bancaires (Visa, Mastercard)
 * - Wave
 */
class ServiceKKiaPay
{
    protected $clePublique;
    protected $clePrivee;
    protected $cleSecrete;
    protected $urlApi;
    protected $urlWebhook;

    public function __construct()
    {
        $this->clePublique = config('kkpay.cle_publique');
        $this->clePrivee = config('kkpay.cle_privee');
        $this->cleSecrete = config('kkpay.cle_secrete');
        $this->urlApi = config('kkpay.url_api', 'https://api.kkiapay.me');
        $this->urlWebhook = config('kkpay.url_webhook', url('/webhook/kkiapay'));
    }

    /**
     * Crée une demande de paiement via KKiaPay
     *
     * @param Abonnement $abonnement - L'abonnement à payer
     * @return array - ['succes' => bool, 'url_paiement' => string, 'reference' => string]
     *
     * Montants:
     * - 5000 centimes = 50 XOF (Basique)
     * - 10000 centimes = 100 XOF (Premium)
     * - 20000 centimes = 200 XOF (VIP)
     */
    public function creerDemandePaiement(Abonnement $abonnement)
    {
        // Référence unique pour ce paiement
        $reference = 'ABO-' . $abonnement->id . '-' . time();

        try {
            // Appel à l'API KKiaPay
            /** @var \Illuminate\Http\Client\Response $reponse */
            $reponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->clePrivee,
                'Content-Type' => 'application/json',
            ])->post(
                $this->urlApi . '/api/v1/transactions/init',
                [
                    'amount' => $abonnement->montant / 100, // KKiaPay veut montant réel (XOF)
                    'reason' => 'Abonnement ' . $abonnement->nom_forfait . ' - Pressing',
                    'metadata' => [
                        'abonnement_id' => $abonnement->id,
                        'utilisateur_id' => $abonnement->utilisateur_id,
                        'forfait' => $abonnement->nom_forfait,
                    ],
                    'callback' => $this->urlWebhook,
                ]
            );

            if ($reponse->successful()) {
                $donnees = $reponse->json();

                return [
                    'succes' => true,
                    'url_paiement' => $donnees['url'] ?? null,
                    'reference' => $reference,
                    'transaction_id' => $donnees['transactionId'] ?? null,
                ];
            }

            Log::error('Erreur KKiaPay: ' . $reponse->body());
            return [
                'succes' => false,
                'erreur' => 'Erreur lors de la création du paiement'
            ];
        } catch (\Exception $e) {
            Log::error('Exception KKiaPay: ' . $e->getMessage());
            return [
                'succes' => false,
                'erreur' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifie l'état d'une transaction
     *
     * @param string $reference - La référence du paiement
     * @return array|null - Les infos de la transaction
     */
    public function verifierPaiement($reference)
    {
        try {
            /** @var \Illuminate\Http\Client\Response $reponse */
            $reponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->clePrivee,
            ])->get(
                $this->urlApi . '/api/v1/transactions/' . $reference
            );

            if ($reponse->successful()) {
                return $reponse->json();
            }

            Log::error('Erreur vérification KKiaPay: ' . $reponse->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Exception vérification KKiaPay: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifie la signature du webhook KKiaPay
     * (pour s'assurer que c'est vraiment KKiaPay qui appelle)
     */
    public function verifierSignatureWebhook($donnees, $signature)
    {
        // KKiaPay envoie: hash_hmac('sha256', json_encode($donnees), cle_secrete)
        $signatureAttendue = hash_hmac(
            'sha256',
            json_encode($donnees, JSON_UNESCAPED_SLASHES),
            $this->cleSecrete
        );

        return hash_equals($signatureAttendue, $signature);
    }
}
