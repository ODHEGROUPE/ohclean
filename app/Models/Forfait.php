<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Représente un forfait d'abonnement pressing
 * Configurable depuis le dashboard admin
 */
class Forfait extends Model
{
    use HasFactory;

    protected $table = 'forfaits';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'montant',
        'duree_jours',
        'credits',
        'caracteristiques',
        'est_populaire',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'caracteristiques' => 'array',
        'est_populaire' => 'boolean',
        'actif' => 'boolean',
    ];

    /**
     * Scope pour les forfaits actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdonne($query)
    {
        return $query->orderBy('ordre')->orderBy('montant');
    }

    /**
     * Relation avec les abonnements
     */
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }

    /**
     * Montant formaté pour affichage
     */
    public function getMontantFormateAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' XOF';
    }

    /**
     * Vérifie si le forfait est illimité
     */
    public function estIllimite()
    {
        return $this->credits >= 999;
    }
}
