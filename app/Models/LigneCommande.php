<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LigneCommande extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'article_id',
        'quantite',
        'prix',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Accès au service via l'article
     */
    public function getServiceAttribute()
    {
        return $this->article?->service;
    }

    /**
     * Calculer le sous-total de la ligne
     */
    public function getSousTotalAttribute(): float
    {
        return $this->prix * $this->quantite;
    }
}
