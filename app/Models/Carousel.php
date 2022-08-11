<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    const ACTIVE = 1;

    protected $fillable = [
        'name',
        'background_image',
        'cover',
        'text',
        'secondary_text',
        'order',
        'action',
        'action_data',
        'status',
    ];

    protected $casts = [
        'cover' => 'boolean',
        'action_data' => 'array',
        'status' => 'boolean'
    ];

    /**
     * Scopes
     */
    public function scopeActive($q){
        return $q->whereStatus(self::ACTIVE);
    }
}
