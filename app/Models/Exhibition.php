<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sponsor_id',
        'name',
        'from_date',
        'to_date',
        'country',
        'city',
        'registration_url'
    ];

    protected $casts = [
        'from_date' => 'date:Y-m-d',
        'to_date'   => 'date:Y-m-d'
    ];

    /**
     * Model Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sponsor(){
        return $this->belongsTo(Sponsor::class);
    }

    public function visits(){
        return $this->morphMany(Visit::class, 'visitable');
    }

    /**
     * Scopes
     */
    public function scopeActiveSubscribedArtist($q) {
        /*
        // Tested and gave same perfermonce
        join('users', 'artworks.user_id', '=', 'users.id')
                ->where('users.status', User::STATUS_ACTIVE)->whereNotNull('users.email_verified_at')
                ->join('subscriptions', 'artworks.user_id', 'subscriptions.user_id')
                ->where('subscriptions.status', Subscription::ACTIVE)->where('subscriptions.expires_at', '>=', now())
        */
        return $q->whereHas('user', fn($q2) => $q2->activeSubscribedArtist());
    }


    /**
     * Attributes
     */
    public function getFromToDateAttribute(){
        if(($this->from_date->format('Y') == $this->to_date->format('Y')) && ($this->from_date->format('M') == $this->to_date->format('M'))){
           return $this->from_date->format('d') . ' - ' . $this->to_date->format('d') . $this->from_date->translatedFormat(' M Y');
        }
        if($this->from_date->format('Y') == $this->to_date->format('Y')) {
            return $this->from_date->translatedFormat('d M') . ' ' . __('to'). ' '. $this->to_date->translatedFormat('d M Y');
        }
        return $this->from_date->translatedFormat('d M Y') . ' ' . __('to'). ' '. $this->to_date->translatedFormat('d M Y');
    }

    /**
     * Functions
     */
    public function generateSlug($name, $id = false, $slug_suffix = '')
    {
        $slug = slugme($name.$slug_suffix);
        if (static::whereSlug($slug)->where('id', '!=', $id)->exists()) {
            return static::generateSlug($name , $id, "-".mt_rand(2, 999));
        }
        return $slug;
    }

}
