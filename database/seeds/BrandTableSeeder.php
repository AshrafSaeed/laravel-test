<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	App\User::all()->each( function ($user){

	        $user->brand()->saveMany(factory('App\Brand'::class, 5)->make()->each(function($brand){

                $brand->media()->saveMany(factory('App\Media'::class, 1)->make());
            
            }));

    	});


    	return true;

    }
}
