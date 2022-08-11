<?php

namespace App\Observers;

use App\Models\Carousel;
use Illuminate\Support\Facades\Cache;

class CarouselObserver
{
    /**
     * Handle the Carousel "created" event.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return void
     */
    public function created(Carousel $carousel)
    {
        Cache::forget('carousels');
    }

    /**
     * Handle the Carousel "updated" event.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return void
     */
    public function updated(Carousel $carousel)
    {
        Cache::forget('carousels');
    }

    /**
     * Handle the Carousel "deleted" event.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return void
     */
    public function deleted(Carousel $carousel)
    {
        Cache::forget('carousels');
    }

    /**
     * Handle the Carousel "restored" event.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return void
     */
    public function restored(Carousel $carousel)
    {
        Cache::forget('carousels');
    }

    /**
     * Handle the Carousel "force deleted" event.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return void
     */
    public function forceDeleted(Carousel $carousel)
    {
        Cache::forget('carousels');
    }
}
