<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(){
        $subscription = auth()->user()->subscription()->first();
        return view('Backend.Subscription.index', compact('subscription'));
    }

    public function payments_history(){
        return view('Backend.Subscription.payments_history');
    }
}
