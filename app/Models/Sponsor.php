<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'website',
        'country',
        'phone',
        'email',
        'address'
    ];

    /**
     * Model Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function exhibitions(){
        return $this->hasMany(Exhibition::class);
    }
}
