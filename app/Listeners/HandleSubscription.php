<?php

namespace App\Listeners;

use App\Events\SubscriptionPayment;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleSubscription
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SubscriptionPayment $event)
    {
        $plan = $event->payment->paymentable;
        $payment_data =  $event->payment->payment_data;
        if ($event->payment->status == Payment::CONFIRMED) {
            $subscription = $event->payment->user->subscription()->create([
                'plan_id' =>  $plan->id,
                'status' => Subscription::ACTIVE,
                'expires_at' => now()->{$payment_data['duration_method']}($payment_data['duration']),
            ]);
        }
    }
}
