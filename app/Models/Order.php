<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'amount',
        'bank_transfer_receipt',
        'comment',
        'paid_at',
        'confirmed_at',
        'canceled_at',
        'denied_at',
        'shipped_at',
        'delivered_at'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function orderable() : MorphTo {
        return $this->morphTo();
    }

    public function amount() : Attribute{
        return Attribute::make(
            set: fn($amount) => $amount*100,
            get: fn($amount) => number_format($amount/100, 2)
        );
    }

    public function pay($comment = null, ?Carbon $date = null) {
        $this->fill(['paid_at' => $date ?: now()]);

        if($comment) $this->fill(['comment' => $comment]);

        $this->save();
        return $this;
    }

    public function confirm($comment = null, ?Carbon $date = null) {
        $this->fill(['confirmed_at' => $date ?: now(), 'canceled_at' => null, 'denied_at' => null]);

        if($comment) $this->fill(['comment' => $comment]);

        $this->save();
        return $this;
    }

    public function ship($comment = null, ?Carbon $date = null) {
        $this->fill(['shipped_at' => $date ?: now(), 'canceled_at' => null, 'denied_at' => null]);

        if(is_null($this->confirmed_at)) $this->fill(['confirmed_at' => $date ?: now()]);

        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function deliver($comment = null, ?Carbon $date = null) {
        $this->fill(['delivered_at' => $date ?: now(), 'canceled_at' => null, 'denied_at' => null]);

        if(is_null($this->confirmed_at)) $this->fill(['confirmed_at' => $date ?: now()]);
        if(is_null($this->shipped_at)) $this->fill(['shipped_at' => $date ?: now()]);

        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function cancel($comment = null, ?Carbon $date = null) {
        $this->fill(['canceled_at' => $date ?: now(), 'denied_at' => null, 'confirmed_at' => null, 'shipped_at' => null, 'delivered_at' => null]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function deny($comment = null, ?Carbon $date = null) {
        $this->fill(['denied_at' => $date ?: now(), 'canceled_at' => null, 'confirmed_at' => null, 'shipped_at' => null, 'delivered_at' => null]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function isPaid() : bool {
        return ! is_null($this->paid_at);
    }

    public function isConfirmed() : bool {
        return ! is_null($this->confirmed_at);
    }

    public function isCanceled() : bool {
        return ! is_null($this->canceled_at);
    }

    public function isDenied() : bool {
        return ! is_null($this->denied_at);
    }

    public function isShipped() : bool {
        return ! is_null($this->shipped_at);
    }

    public function isDelivered() : bool {
        return ! is_null($this->delivered_at);
    }
}
