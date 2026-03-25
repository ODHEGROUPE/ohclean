<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdheContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'story_badge',
        'story_title',
        'story_text_1',
        'story_text_2',
        'story_image',
        'team_title',
        'team_subtitle',
    ];
}
