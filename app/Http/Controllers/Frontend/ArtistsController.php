<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function index()
    {
        //Page meta data
        $meta = new Meta([
            'title' => __('Artists'),
        ]);

        //Filtering
        $getByArtistTypeList = ['all' => 'All','artist' => 'artist', 'calligrapher' => 'calligrapher'];
        $currentArtistType = request()->get('artist_type', 'all');

        $artists = User::role('artist')->activeSubscribedArtist()
            ->withCount('artworks')
            ->when(in_array($currentArtistType, config('app.artist_types', [])), fn($q) => $q->where('artist_type', $currentArtistType))
            ->latest('artworks_count')
            ->paginate(30);

        if ($artists->currentPage() > $artists->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $artists->lastPage()]));
        }

        return view('Frontend.Artists.index', compact('artists', 'getByArtistTypeList', 'currentArtistType'));
    }
}
