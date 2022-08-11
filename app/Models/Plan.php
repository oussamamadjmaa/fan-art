<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const FREE_TRIAL_KEY = "free_trial";

    protected $fillable = [
        'key',
        'name',
        'short_description',
        'description',
        'features',
        'price',
    ];

    protected $casts = [
        'features' => 'array'
    ];

}
