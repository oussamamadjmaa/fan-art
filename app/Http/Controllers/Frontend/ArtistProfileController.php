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
            abort_if(!empty($request->route('profile_page')) && !in_array($request->route('profile_page'), []), 404);
            return $next($request);
        });
    }
    public function index($artist_username, $profile_page = "artworks") {
        $artist = User::role('artist')->whereUsername($artist_username)->with('profile')->activeSubscribedArtist()->firstOrFail();

        //Visits count
        if(!auth()->check() || auth()->id() != $artist->id){
            $visits = $artist->visits()->firstOrCreate(['visits_date' => now()->format('Y-m-d')], ['count' => 0]);
            $visits->increment('count');
        }

        //Page meta data
        $meta = new Meta([
            'title' => $artist->name,
            'description' => str($artist->profile?->description)->limit(160)->toString(),
            'image'    => $artist->avatar_url
        ]);

        //Filtering
        $sortByList = ['latest' => 'Latest', 'oldest' => 'Oldest'];
        $currentSortBy = request()->get('sortBy', 'latest');

        //Artist artworks
        $artist_artworks = NULL;

        if($profile_page == "artworks") {
             //Filtering
            $sortByList = ['latest' => 'Latest', 'lowest_price' => 'Price (Low to High)' , 'highest_price' => 'Price (High to Low)', 'oldest' => 'Oldest'];

            $artist_artworks = $artist->artworks()
                                        ->when(($currentSortBy == 'latest' || !array_key_exists($currentSortBy, $sortByList)) , fn($q) => $q->latest())
                                        ->when(($currentSortBy == 'highest_price') , fn($q) => $q->latest('price'))
                                        ->when(($currentSortBy == 'lowest_price') , fn($q) => $q->oldest('price'))
                                        ->when(($currentSortBy == 'oldest') , fn($q) => $q->oldest())->paginate(12);
            if($artist_artworks->currentPage() > $artist_artworks->lastPage()) {
                return redirect(request()->fullUrlWithQuery(['page' => $artist_artworks->lastPage()]));
            }
        }

        //Artist Blogs
        $artist_blogs = NULL;

        if($profile_page == "blogs") {
            //Filtering
            $sortByList = ['latest' => 'Latest', 'oldest' => 'Oldest'];

            $artist_blogs = $artist->news()
                                    ->when(($currentSortBy == 'latest' || !array_key_exists($currentSortBy, $sortByList)) , fn($q) => $q->latest())
                                    ->when(($currentSortBy == 'oldest') , fn($q) => $q->oldest())
                                    ->published()->paginate(16);
            if($artist_blogs->currentPage() > $artist_blogs->lastPage()) {
                return redirect(request()->fullUrlWithQuery(['page' => $artist_blogs->lastPage()]));
            }
        }

        return view('Frontend.Artist.profile', compact('artist', 'artist_artworks', 'artist_blogs', 'profile_page', 'sortByList', 'currentSortBy'));
    }
}
