<?php

namespace App\Models;

use App\Observers\NotificationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['from_user_id', 'to_user_id', 'notifiable_id', 'notifiable_type', 'type', 'seen_at', 'created_at', 'updated_at'];

    protected $casts = [
        'seen_at' => 'datetime'
    ];

    public function from_user(){
        return $this->belongsTo(User::class, 'from_user_id')->withDefault([
            'username' => 'fanart',
            'name' => config('app.name'),
            'avatar' => 'avatars/defaults/art-logo.png',
        ]);
    }

    public function to_user(){
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function notifiable(){
        return $this->morphTo();
    }

    public function markAsRead(){
        return $this->update(['seen_at' => now()]);
    }

    public function scopeUnseen($q){
        return $q->whereNull('seen_at');
    }
}
