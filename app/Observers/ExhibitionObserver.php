<?php

namespace App\Observers;

use App\Models\Exhibition;

class ExhibitionObserver
{
    public function creating(Exhibition $exhibition){
        $exhibition->slug = $exhibition->generateSlug($exhibition->name);
    }

    public function updating(Exhibition $exhibition){
        $exhibition->slug = $exhibition->generateSlug($exhibition->name, $exhibition->id);
    }
}
