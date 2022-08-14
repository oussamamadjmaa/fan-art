<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const PENDING = 0;
    const CONFIRMED = 1;
    const DECLINED = 2;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'payment_method',
        'confirmation_picture',
        'payment_data',
        'price',
        'description',
        'status',
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    /**
     * Relations
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function paymentable()
    {
        return $this->morphTo();
    }
}
