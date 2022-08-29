<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ArtistPorfileSetupRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArtistProfileSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware(function(Request $request, Closure $next){
            abort_if(!in_array($request->route('step'), ['my-profile']), 404);
            if(auth()->user()->profile()->count() && auth()->user()->avatar) {
                return to_route('backend.dashboard');
            }
            return $next($request);
        });
    }

    public function index($step){
        return view('Frontend.ProfileSetup.artist.my-profile');
    }

    public function save(ArtistPorfileSetupRequest $request, $step){
        $data = $request->validated();

        $data['social_media'] = [
            'facebook' => $data['facebook'] ?? NULL,
            'instagram' => $data['instagram'] ?? NULL,
            'linkedin' => $data['linkedin'] ?? NULL,
            'twitter' => $data['twitter'] ?? NULL,
        ];

        $data['docs'] = [
            'cv' => ($request->has('cv') && $request->file('cv')) ? $request->file('cv')->store('artists-cvs', 'public') : NULL
        ];

        auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $data);

        Cache::forget('latest_artists');

        return to_route('backend.dashboard');
    }
}
