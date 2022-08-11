<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'skype',
        'password',
        'status',
        'avatar',
        'country',
        'nationality',
        'address',
        'gender',
        'website'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Model Relations
     */

    public function profile(){
        return $this->hasOne(UserProfile::class);
    }

    public function news(){
        return $this->hasMany(News::class);
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function artworks(){
        return $this->hasMany(Artwork::class);
    }

    public function activeSubscription(){
        return $this->hasOne(Subscription::class)->where('subscriptions.status', Subscription::ACTIVE)->where('subscriptions.expires_at', '>=', now());
    }

    /**
     * Get Attributes
     */
    public function getAvatarAttribute($avatar){
        $this->append('avatar_url');
        return $avatar;
    }

    public function getFullnameAttribute(){
        return $this->name;
    }

    /**
     * Append Attributes
     */
    public function getAvatarUrlAttribute(){
        return $this->avatar ? asset('storage/'.$this->avatar) : asset(config('app.default_avatar'));
    }

    /**
     * Scopes
     */
    public function scopeActive($q){
        return $q->whereStatus(self::STATUS_ACTIVE);
    }
    public function scopeVerified($q){
        return $q->whereNotNull('email_verified_at');
    }
    public function scopeSubscribed($q){
        return $q->whereHas('activeSubscription');
    }

    public function scopeActiveSubscribedArtist($q) {
        return $q->active()->verified()->subscribed();
    }
}
