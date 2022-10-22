<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function index()
    {
        //Page meta data
        $meta = new Meta([
            'title' => __('Artists'),
        ]);

        $artists = User::role('artist')->activeSubscribedArtist()
            ->latest()
            ->paginate(16);

        if ($artists->currentPage() > $artists->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $artists->lastPage()]));
        }

        return view('Frontend.Artists.index', compact('artists'));
    }
}
