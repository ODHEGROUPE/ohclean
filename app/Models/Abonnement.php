<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Forfait;

/**
 * Représente un abonnement pressing
 *
 * Exemple:
 * - Client A s'abonne au Forfait Premium
 * - Paie 10000 XOF pour 30 jours
 * - Reçoit 30 lessives à faire
 */
class Abonnement extends Model
{
    use HasFactory;

    protected $table = 'abonnements';

    protected $fillable = [
        'utilisateur_id',
        'forfait_id',
        'nom_forfait',
        'montant',
        'duree_jours',
        'credits',
        'credits_initiaux',
        'identifiant_transaction_kkpay',
        'etat',
        'date_debut',
        'date_expiration',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_expiration' => 'datetime',
    ];

    // Relation avec l'utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Relation avec le forfait
    public function forfait()
    {
        return $this->belongsTo(Forfait::class);
    }

    /**
     * Vérifier si l'abonnement est actuellement valide
     * actif = etat='actif' ET la date n'a pas expiré
     */
    public function estActif()
    {
        return $this->etat === 'actif' &&
               now()->lessThan($this->date_expiration);
    }

    /**
     * Vérifier si l'abonnement a expiré
     */
    public function estExpire()
    {
        return $this->date_expiration && now()->greaterThan($this->date_expiration);
    }

    /**
     * Nombre de jours restants avant expiration
     */
    public function joursRestants()
    {
        if (!$this->date_expiration) return 0;
        return now()->diffInDays($this->date_expiration);
    }
}
