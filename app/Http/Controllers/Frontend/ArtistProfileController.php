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

        //Visits count
        if(!auth()->check() || auth()->id() != $artist->id){
            $visits = $artist->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        //Page meta data
        $meta = new Meta([
            'title' => $artist->name,
            'description' => str($artist->profile->description)->limit(160)->toString(),
            'image'    => $artist->avatar_url
        ]);

        //Artist artworks
        $artist_artworks = NULL;

        if($profile_page == "artworks") {
            $artist_artworks = $artist->artworks()->latest()->paginate(12);
            if($artist_artworks->currentPage() > $artist_artworks->lastPage()) {
                return redirect(request()->fullUrlWithQuery(['page' => $artist_artworks->lastPage()]));
            }
        }

        //Artist Blogs
        $artist_blogs = NULL;

        if($profile_page == "blogs") {
            $artist_blogs = $artist->news()->published()->latest()->paginate(16);
            if($artist_blogs->currentPage() > $artist_blogs->lastPage()) {
                return redirect(request()->fullUrlWithQuery(['page' => $artist_blogs->lastPage()]));
            }
        }

        return view('Frontend.Artist.profile', compact('artist', 'artist_artworks', 'artist_blogs', 'profile_page'));
    }
}
