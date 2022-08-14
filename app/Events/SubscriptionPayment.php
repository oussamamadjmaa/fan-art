<?php

namespace App\Events;

use App\Models\Plan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPayment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }
}
