<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelArtworksOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_name',
        'city',
        'responsible_person',
        'email',
        'phone',
        'quantity',
        'sizes',
        'idea',
        'ip_address'
    ];

    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
