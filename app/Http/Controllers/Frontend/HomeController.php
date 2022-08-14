<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
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
        //Page meta data
        $meta = new Meta([
            'title' => __('Home'),
        ]);

        //Carousels
        $carousels = Cache::rememberForever('carousels', function () {
            return Carousel::active()->oldest('order')->get();
        });

        //Latest Registered Artists
        $latest_artists = Cache::remember('latest_artists', (60*60), function () {
            return User::role('artist')->active()->verified()->whereHas('profile')->whereHas('subscription', fn ($q) => $q->active())->latest()->limit(10)->get();
        });

        //Latest Artworks & Paintings
        $latest_artworks = Artwork::where('artworks.status', '!=', Artwork::SOLD)->activeSubscribedArtist()->latest('artworks.created_at')->limit(6)->get();

        return view('Frontend.home', compact('carousels', 'latest_artists', 'latest_artworks'));
    }
}
