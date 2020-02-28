<?php

namespace App\Repositories\Brand;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Brand\BrandRepositoryImplement;
use App\Repositories\Brand\BrandRepository;


class BrandServiceProvider extends ServiceProvider
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
            BrandRepositoryImplement::class, 
            BrandRepository::class 
        );
    }
}
