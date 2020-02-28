<?php

namespace App\Repositories\Location;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Location\LocationRepositoryImplement;
use App\Repositories\Location\LocationRepository;


class LocationServiceProvider extends ServiceProvider
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
            LocationRepositoryImplement::class, 
            LocationRepository::class 
        );
    }
}
