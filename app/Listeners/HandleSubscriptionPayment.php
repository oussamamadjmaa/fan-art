<?php

namespace App\Listeners;

use App\Events\SubscriptionPayment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleSubscriptionPayment
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
            if(isset($payment_data['action']) && $payment_data['action'] == "renew"){
                $expires_at = $event->payment->user->subscription->expires_at->{$payment_data['duration_method']}($payment_data['duration']);
            }else{
                $expires_at = now()->{$payment_data['duration_method']}($payment_data['duration']);
            }
            $subscription = Subscription::updateOrCreate(['user_id', $event->payment->user_id], [
                'plan_id' =>  $plan->id,
                'status' => Subscription::ACTIVE,
                'expires_at' => $expires_at,
            ]);
        }else if($event->payment->status == Payment::PENDING){
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                $event->payment->notifications()->create([
                    'from_user_id' => $event->payment->user_id,
                    'to_user_id' => $admin->id,
                    'type'  => 'subscription.new_pending_payment'
                ]);
            }
        }
    }
}