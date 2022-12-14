<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;


    const NOT_READY = 0; //this option has been disabled
    const READY = 1;
    const SOLD = 2;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
       // 'description',
        'price',
        'image',
       // 'materials_used',
       // 'tools',
        'type',
        'outer_frame',
        'dimensions',
       // 'covered_with_glass',
        'location',
        'status',
        'url',
    ];

    protected $casts = [
        'outer_frame' => 'boolean',
        //'covered_with_glass' => 'boolean',
    ];

    /**
     * Model Relations
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->morphMany(Message::class, 'messageable');
    }

    //
    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function visits(){
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function orders() {
        return $this->morphMany(Order::class, 'orderable');
    }

    /**
     * Scopes
     */
    public function scopeReady($q){
        return $q->whereStatus(self::READY);
    }
    public function scopeNotReady($q){
        return $q->whereStatus(self::NOT_READY);
    }
    public function scopeSold($q){
        return $q->whereStatus(self::SOLD);
    }

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
     * Append attributes
     */
    public function getPriceAttribute($price){
        $this->append('price_format');
        return $price;
    }

    public function getPriceFormatAttribute(){
        return price_format($this->price);
    }

    public function getStatusAttribute($status){
        $this->append('status_text');
        return $status;
    }

    public function getStatusTextAttribute(){
        $text = 'Unknown';
        switch ($this->status) {
            case self::NOT_READY:
                $text = "In preparation";
                break;
            case self::READY:
                $text = "Ready for delivery";
                break;
            case self::SOLD:
                $text = "Sold";
                break;
        }
        return __($text);
    }

    /**
     * Functions
     */
    public function hasMessageFromThisSender(){
        return $this->messages()->when(auth()->check(),
                                        fn($q) => $q->where('sender_type', 'App\Models\User')->where('sender_id', auth()->id()),
                                        fn($q) => $q->where('data->ip_address', request()->ip()))
                                        ->count();
    }

    public function generateSlug($title, $id = false, $slug_suffix = '')
    {
        $slug = slugme($title.$slug_suffix);
        if (static::whereSlug($slug)->where('id', '!=', $id)->exists()) {
            return static::generateSlug($title , $id, "-".mt_rand(2, 999));
        }
        return $slug;
    }
}
