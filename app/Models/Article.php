<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'nom',
        'description',
        'prix',
        'actif',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'actif' => 'boolean',
    ];

    /**
     * Un article appartient à un service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Un article peut être dans plusieurs lignes de commande
     */
    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }
}
