<?php

namespace App\Providers;

use App\Campaign;
use App\Policies\CampaignPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Campaign::class => CampaignPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Campaign Policy
        Gate::resource('campaign', 'App\Policies\CampaignPolicy');
        Gate::define('campaign.publish', 'App\Policies\CampaignPolicy@publish');
        Gate::define('campaign.unpublish', 'App\Policies\CampaignPolicy@unpublish');

        // Brand Policy
        Gate::resource('brand', 'App\Policies\BrandPolicy');

        // Location Policy
        Gate::resource('location', 'App\Policies\LocationPolicy');

    }
}
