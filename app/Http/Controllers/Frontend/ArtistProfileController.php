<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
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
        $artist = User::role('artist')->whereUsername($artist_username)->withWhereHas('profile')->activeSubscribedArtist()->firstOrFail();

        //Page meta data
        $meta = new Meta([
            'title' => $artist->name,
        ]);

        //
        $artist_artworks = NULL;

        if($profile_page == "artworks") {
            $artist_artworks = $artist->artworks()->latest()->paginate(12);
            if($artist_artworks->currentPage() > $artist_artworks->lastPage()) {
                return redirect(request()->fullUrlWithQuery(['page' => $artist_artworks->lastPage()]));
            }
        }

        return view('Frontend.Artist.profile', compact('artist', 'artist_artworks', 'profile_page'));
    }
}
