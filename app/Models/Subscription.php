<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    const PENDING = 0;
    const ACTIVE = 1;
    const CANCELED = 2;
    const CANCELED_BY_USER = 3;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'payment_data' => 'array',
        'expires_at' => 'datetime'
    ];

    /**
     * Relations
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Attributes
     */
    public function getStatusAttribute($status){
        $this->append('status_text');
        return $status;
    }

    public function getStatusTextAttribute(){
        $text = 'Unknown';
        if($this->expired()){
            $text = 'Expired';
        }else{
            switch ($this->status) {
                case self::PENDING:
                    $text = "Pending";
                    break;
                case self::ACTIVE:
                    $text = "Active";
                    break;
                case self::CANCELED:
                    $text = "Canceled";
                    break;
                case self::CANCELED_BY_USER:
                    $text = "Canceled by user";
                    break;
            }
        }

        return __($text);
    }

    /**
     * Functions
     */
    public function is_free(){
        return $this->plan->key == Plan::FREE_TRIAL_KEY;
    }
    public function days_left(){
        return $this->expires_at->diffInDays(now()->subDay());
    }
    public function expired(){
        return now()->gt($this->expires_at);
    }

    /**
     * Scopes
     */
    public function scopeActive($q){
        return $q->where('subscriptions.status', Subscription::ACTIVE)->where('subscriptions.expires_at', '>=', now());
    }
}
