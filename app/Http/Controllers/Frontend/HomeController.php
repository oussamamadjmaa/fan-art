<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Carousels
        $carousels = Cache::rememberForever('carousels', function(){
            return Carousel::active()->oldest('order')->get();
        });

        //Latest Registered Artists
        $latest_artists = Cache::rememberForever('latest_artists', function(){
            return User::role('artist')->active()->verified()->whereHas('profile')->whereHas('activeSubscription')->latest()->limit(10)->get();
        });

        //Latest Artworks & Paintings
        $latest_artworks = Artwork::where('artworks.status', '!=', Artwork::SOLD)->activeSubscribedArtist()->latest('artworks.created_at')->limit(6)->get();

        return view('Frontend.home', compact('carousels', 'latest_artists', 'latest_artworks'));
    }
}
