<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Artwork'    => 'App\Policies\ArtworkPolicy',
        'App\Models\Sponsor'    => 'App\Policies\SponsorPolicy',
        'App\Models\Exhibition'    => 'App\Policies\ExhibitionPolicy',
        'App\Models\Sponsor'    => 'App\Policies\SponsorPolicy',
        'App\Models\News'    => 'App\Policies\BlogPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
