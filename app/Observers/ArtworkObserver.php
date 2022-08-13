<?php

namespace App\Observers;

use App\Models\Artwork;

class ArtworkObserver
{
    public function creating(Artwork $artwork){
        $artwork->slug = $artwork->generateSlug($artwork->title);
    }

    public function updating(Artwork $artwork){
        $artwork->slug = $artwork->generateSlug($artwork->title, $artwork->id);
    }
}
