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
        'transaction_id',
        'payment_method',
        'confirmation_picture',
        'payment_data',
        'price',
        'description',
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
     * Functions
     */
    public function is_free(){
        return $this->plan->key == Plan::FREE_TRIAL_KEY;
    }
    public function days_left(){
        return $this->expires_at->diffInDays(now()->subDay());
    }
}
