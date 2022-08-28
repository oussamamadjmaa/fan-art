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
        'amount',
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

    public function notifications(){
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Scopes
     */
    public function scopePending($q){
        return $q->whereStatus(self::PENDING);
    }

    public function scopeConfirmed($q){
        return $q->whereStatus(self::CONFIRMED);
    }
    public function scopeDeclined($q){
        return $q->whereStatus(self::DECLINED);
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
        switch ($this->status) {
            case self::PENDING:
                $text = "Pending";
                break;
            case self::CONFIRMED:
                $text = "Confirmed";
                break;
            case self::DECLINED:
                $text = "Declined";
                break;
        }

        return __($text);
    }
    public function getStatusColorAttribute(){
        $color = 'dark';
        switch ($this->status) {
            case self::PENDING:
                $color = "warning";
                break;
            case self::CONFIRMED:
                $color = "success";
                break;
            case self::DECLINED:
                $color = "danger";
                break;
        }

        return __($color);
    }

}
