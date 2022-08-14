<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(){
        $subscription = auth()->user()->subscription()->first();
        $higher_plans = Plan::where('level', '>', $subscription->plan->level)->get();
        return view('Backend.Subscription.index', compact('subscription', 'higher_plans'));
    }

    public function payments_history(){
        return view('Backend.Subscription.payments_history');
    }
}
