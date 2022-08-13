<?php

namespace App\Observers;

use App\Models\News;

class NewsObserver
{
    public function creating(News $news){
        $news->user_id = auth()->id();
        $news->slug = $news->generateSlug($news->title);
    }

    public function updating(News $news){
        $news->slug = $news->generateSlug($news->title, $news->id);
    }
}
