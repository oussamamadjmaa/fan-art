<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BackendCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $check = "profile")
    {

        if(auth()->user()->hasRole('admin')) return $next($request);

        abort_if(!auth()->user()->hasRole(['admin', 'artist', 'store']), 404);

        if($check == "profile" && auth()->user()->hasRole('artist') && (!auth()->user()->avatar || !auth()->user()->profile()->count())){
            return to_route('frontend.setup_profile.index', 'my-profile');
        }

        if($check == "subscribed" && auth()->user()->hasRole('artist') && !auth()->user()->subscription()->active()->count()){
            return to_route('backend.subscription.index');
        }
        return $next($request);
    }
}
