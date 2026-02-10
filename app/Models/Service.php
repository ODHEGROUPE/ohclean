<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'image',
    ];

    /**
     * Un service a plusieurs articles
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Articles actifs du service
     */
    public function articlesActifs(): HasMany
    {
        return $this->hasMany(Article::class)->where('actif', true);
    }
}
