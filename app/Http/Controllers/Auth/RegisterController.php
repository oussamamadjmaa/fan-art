<?php

namespace App\Http\Controllers\Auth;

use App\Events\SubscriptionPayment;
use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function(Request $request, Closure $next){
            abort_if(!in_array($request->route('role'), ['customer', 'artist', 'store']), 404);
            return $next($request);
        });
    }
    public function index($role){
        $meta = new Meta([
            'title' => __('Register')
        ]);

        $countries_list = countries_list(true, true);

        return view('auth.register.'.$role, compact('role'));
    }

    public function register(RegisterRequest $request, $role){
        $data = $request->validated();
        $data['status'] = User::STATUS_ACTIVE;
        $data['password'] = bcrypt($data['password']);

        if($role == "artist") {
            $data['avatar'] = config('app.artist_default_avatar.'.($data['gender'] ?? 'male'));
        }else if($role == "store") {
            $data['avatar'] = config('app.store_default_avatar');
        }

        event(new Registered($user = User::create($data)));

        if($role != 'customer') {
            $user->assignRole($role);
            $plan = Plan::where('key', 'free_trial')->first();
            $profile = $user->profile()->create();
            if($plan) {
                event(new SubscriptionPayment($payment = $this->createFreeTrialPayment($user, $plan)));
            }
        }

        Auth::guard()->login($user);

        return $this->redirectTo($role);
    }

    public function redirectTo($role){
        $routes = [
            'artist'    => route('frontend.setup_profile.index', 'my-profile'),
            'store'     => route('backend.dashboard'),
        ];

        return redirect($routes[$role] ?? RouteServiceProvider::HOME);
    }

    private function createFreeTrialPayment(User $user, Plan $plan){
        return $plan->payments()->create([
            'user_id' =>  $user->id,
            'payment_method' => 'free_trial',
            'payment_data' => [
                'duration' => config('app.subscription.free_trial_days'),
                'duration_method' => 'addDays',
                'duration_type' => 'days',
            ],
            'amount' => 0,
            'description' => 'Automatic subscription to the free trial plan',
            'status' => Payment::CONFIRMED,
        ]);
    }
}
