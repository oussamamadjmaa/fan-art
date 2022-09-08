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
        'last_seen_at' => 'datetime',
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

    public function latest_blog(){
        return $this->hasOne(News::class)->latest();
    }

    public function activeSubscription(){
        return $this->hasOne(Subscription::class)->active();
    }

    public function subscription(){
        return $this->hasOne(Subscription::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class, 'to_user_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function visits(){
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function support_tickets(){
        return $this->hasMany(SupportTicket::class);
    }

    //Artist Relations
    public function artworks(){
        return $this->hasMany(Artwork::class);
    }
    public function sponsors(){
        return $this->hasMany(Sponsor::class);
    }
    public function exhibitions(){
        return $this->hasMany(Exhibition::class);
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
        return $this->avatar ? storage_url($this->avatar) : storage_url(config('app.default_avatar'));
    }

    /**
     * Scopes
     */
    public function scopeActive($q){
        return $q->where('users.status', '=', self::STATUS_ACTIVE);
    }
    public function scopeVerified($q){
        return $q->whereNotNull('users.email_verified_at');
    }
    public function scopeSubscribed($q){
        return $q->whereHas('profile')->whereHas('subscription', fn($q) => $q->active());
    }

    public function scopeActiveSubscribedArtist($q) {
        return $q->active()->verified()->subscribed();
    }
}
