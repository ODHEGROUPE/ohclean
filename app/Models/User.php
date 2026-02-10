<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Abonnement;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'adresse',
        'ville',
        'role',
    ];

    public function getInitials(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(
            (substr($parts[0], 0, 1) ?? '') .
            (substr($parts[1] ?? '', 0, 1) ?? '')
        );
    }

    /**
     * Obtient le label du rôle formaté
     */
public function getRoleLabel(): string
{
    return match($this->role) {
        'ADMIN' => 'Administrateur',
        'AGENT_PRESSING' => 'Agent Pressing',
        'CLIENT' => 'Client',
        default => $this->role,
    };
}

public function isAdmin(): bool
{
    return $this->role === 'ADMIN';
}

public function isModerator(): bool
{
    return $this->role === 'AGENT_PRESSING';
}

public function isUser(): bool
{
    return $this->role === 'CLIENT';
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function commandes(): HasMany
{
    return $this->hasMany(Commande::class);
}
public function notifications(): HasMany
{
    return $this->hasMany(Notification::class);
}

/**
 * Relation avec les abonnements
 */
public function abonnements(): HasMany
{
    return $this->hasMany(Abonnement::class, 'utilisateur_id');
}

/**
 * Obtenir l'abonnement actif
 */
public function abonnementActif()
{
    return $this->abonnements()
        ->where('etat', 'actif')
        ->where('date_expiration', '>', now())
        ->latest()
        ->first();
}

/**
 * Vérifier si l'utilisateur a un abonnement actif
 */
public function aUnAbonnementActif(): bool
{
    return $this->abonnementActif() !== null;
}

}
