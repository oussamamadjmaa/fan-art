<?php

namespace App\Providers;

use App\Models\Artwork;
use App\Models\Carousel;
use App\Models\News;
use App\Models\User;
use App\Models\Exhibition;
use App\Observers\ArtworkObserver;
use App\Observers\CarouselObserver;
use App\Observers\NewsObserver;
use App\Observers\UserObserver;
use App\Observers\ExhibitionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        User::class => UserObserver::class,
        News::class => NewsObserver::class,
        Artwork::class => ArtworkObserver::class,
        Carousel::class => CarouselObserver::class,
        Exhibition::class => ExhibitionObserver::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
