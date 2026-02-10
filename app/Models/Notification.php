<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;
        protected $fillable = [
        'user_id',
        'message',
        'dateEnvoi',
    ];

    protected $casts = [
        'dateEnvoi' => 'date',
    ];

        public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
