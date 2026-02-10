<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    /** @use HasFactory<\Database\Factories\CommandeFactory> */
    use HasFactory;
        protected $fillable = [
        'user_id',
        'dateCommande',
        'dateLivraison',
        'date_recuperation',
        'lieu_recuperation',
        'latitude_collecte',
        'longitude_collecte',
        'heure_livraison',
        'statut',
        'numSuivi',
        'montantTotal',
        'facture',
        'latitude',
        'longitude',
        'adresse_livraison',
        'instructions',
    ];

    protected $casts = [
        'dateCommande' => 'datetime',
        'dateLivraison' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

}


