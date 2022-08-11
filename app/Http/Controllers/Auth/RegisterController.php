<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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

        event(new Registered($user = User::create($data)));

        if($role != 'customer') {
            $user->assignRole($role);
            $plan = Plan::where('key', 'free_trial')->first();
            if($plan) {
                $user->subscriptions()->create([
                    'plan_id' =>  $plan->id,
                    'payment_method' => 'free_trial',
                    'payment_data' => [],
                    'price' => 0,
                    'description' => 'الإشتراك التلقائي في '.$plan->name.' لمدة 6 أشهر',
                    'status' => Subscription::ACTIVE,
                    'expires_at' => now()->addDays(180),
                ]);
            }
        };

        Auth::guard()->login($user);

        return $this->redirectTo($role);
    }

    public function redirectTo($role){
        $routes = [
            'artist' => route('frontend.setup_profile.index', 'my-profile'),
        ];

        return redirect($routes[$role] ?? RouteServiceProvider::HOME);
    }
}
