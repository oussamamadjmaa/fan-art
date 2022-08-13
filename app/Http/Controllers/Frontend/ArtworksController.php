<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworksController extends Controller
{
    public function index(){
         //Page meta data
         $meta = new Meta([
            'title' => __('Paintings and artwork'),
        ]);

        //
        $artworks = Artwork::query();
        $artworks = $artworks->latest()->paginate(12);

        if($artworks->currentPage() > $artworks->lastPage()) {
            return redirect(request()->fullUrlWithQuery(['page' => $artworks->lastPage()]));
        }

        return view('Frontend.Artworks.index', compact('artworks'));
    }

    public function show(Artwork $artwork){
        //Page meta data
        $meta = new Meta([
            'title' => $artwork->title,
            'description' => str($artwork->description)->limit(160)->toString(),
        ]);
        return view('Frontend.Artworks.show', compact('artwork'));
    }
}
