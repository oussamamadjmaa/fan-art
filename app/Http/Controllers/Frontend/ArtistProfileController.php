<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ArtistProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(function(Request $request, Closure $next){
            abort_if(!empty($request->route('profile_page')) && !in_array($request->route('profile_page'), ['blogs']), 404);
            return $next($request);
        });
    }
    public function index($artist_username, $profile_page = "artworks") {
        $artist = User::whereUsername($artist_username)->withWhereHas('profile')->activeSubscribedArtist()->firstOrFail();

        $artist_artworks = NULL;

        if($profile_page == "artworks") {
            $artist_artworks = $artist->artworks()->latest()->paginate(12);
        }

        return view('Frontend.Artist.profile', compact('artist', 'artist_artworks', 'profile_page'));
    }
}
