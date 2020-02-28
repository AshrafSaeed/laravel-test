<?php

namespace App\Repositories\Campaign;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Campaign\CampaignRepositoryImplement;
use App\Repositories\Campaign\CampaignRepository;


class CampaignServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        
        $this->app->bind(
            CampaignRepositoryImplement::class, 
            CampaignRepository::class 
        );
    }
}
