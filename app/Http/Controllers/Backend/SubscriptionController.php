<?php

namespace App\Http\Controllers\Backend;

use App\Events\NewNotificationEvent;
use App\Events\SubscriptionPayment;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Rules\ValidateFileRule;
use Illuminate\Http\Request;
use App\Models\Notification;

class SubscriptionController extends Controller
{
    public function index(){
        $subscription = auth()->user()->subscription()->first();
        $higher_plans = Plan::where('level', '>', $subscription->plan->level)->get();
        return view('Backend.Subscription.index', compact('subscription', 'higher_plans'));
    }

    public function upgrade_plan(Request $request){
        $request_data = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'duration' => ['required', 'in:yearly'],
            'bank_transfer_receipt' => ['required', new ValidateFileRule('confirmation_pictures', ['png', 'jpg', 'jpeg', 'webp'])],
        ]);

        $current_subscription = auth()->user()->subscription;
        $new_plan = Plan::find($request_data['plan_id']);
        $current_subscription_plan = $current_subscription->plan;

        if(($current_subscription_plan->key != Plan::FREE_TRIAL_KEY && auth()->user()->activeSubscription()->count())
            || $new_plan->level <= $current_subscription_plan->level
            || auth()->user()->payments()->pending()->count()){
            return abort('403', __("You're not allowed to perform this action"));
        }

        if($request_data['duration'] == "yearly") {
            $payment = $new_plan->payments()->create([
                'user_id' =>  auth()->id(),
                'payment_method' => 'bank_transfer',
                'payment_data' => [
                    'duration' => 1,
                    'duration_method' => 'addYear',
                    'duration_type' => 'year',
                ],
                'amount' => $new_plan->price,
                'confirmation_picture' => $request_data['bank_transfer_receipt'],
                'description' => NULL,
                'status' => Payment::PENDING,
            ]);
        }

        event(new SubscriptionPayment($payment));

        return to_route('backend.subscription.payment_history')->with('success', __('Your order has been sent successfully'));
    }

    public function payment_history(){
        if(request()->expectsJson()){
            $payments = auth()->user()->payments();
            $payments = $payments->with('paymentable')->latest('id')->cursorPaginate(15)->withQueryString();
            $slot = array_merge($payments->toArray(), ['data' => view('Backend.Subscription.payment_history.list', compact('payments'))->render()]);
            return response()->json($slot);
        }

        return view('Backend.Subscription.payment_history.index');
    }
}
