<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /** @use HasFactory<\Database\Factories\PaiementFactory> */
    use HasFactory;
        protected $fillable = [
        'commande_id',
        'montant',
        'datePaiement',
        'moyenPaiement',
    ];

    protected $casts = [
        'datePaiement' => 'date',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
