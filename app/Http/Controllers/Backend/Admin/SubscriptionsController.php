<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Events\SubscriptionPayment;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index($status = "all"){
        if(request()->expectsJson()){
            $payments = Payment::query();
            $payments->when(in_array($status, ['pending', 'confirmed', 'declined']), fn($q) => $q->{$status}());
            $payments = $payments->withWhereHas('user', fn($q) => $q->select('id', 'name'))->with('paymentable')->latest('id')->cursorPaginate(25)->withQueryString();
            $slot = array_merge($payments->toArray(), ['data' => view('Backend.Admin.Subscriptions.list', compact('payments'))->render()]);
            return response()->json($slot);
        }

        $payments_stats = [
            'pending' => Payment::pending()->count(),
            'confirmed' => Payment::confirmed()->count(),
            'declined' => Payment::declined()->count(),
        ];

        return view('Backend.Admin.Subscriptions.index', compact('payments_stats'));
    }

    public function review_payment(Payment $payment){
        $payment->load('user');
        abort_if(!$payment->user, 404);

        return view('Backend.Admin.Subscriptions.review-payment', compact('payment'));
    }

    public function payment_status_action(Request $request, Payment $payment, $status) {
        if(!in_array($status, ['confirm', 'decline']) || $payment->status != Payment::PENDING){
            return to_route('backend.subscriptions-management.review-payment', $payment->id);
        }

        $payment->load('user');
        abort_if(!$payment->user, 404);

        $request->validate([
            'note' => 'nullable|string',
        ]);

        $payment->status = ($status == "confirm") ? Payment::CONFIRMED : Payment::DECLINED;
        if($request->input('note')) $payment->description = $request->input('note');
        $payment->save();

        event(new SubscriptionPayment($payment));

        return to_route('backend.subscriptions-management.review-payment', $payment->id)->withSuccess(__(($status == "confirm") ? 'Payment confirmed successfully' : 'Payment declined successfully'));
    }
}
