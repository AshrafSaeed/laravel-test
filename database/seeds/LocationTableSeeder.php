<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\User::all()->each( function ($user){
            $user->location()->saveMany(factory('App\Location'::class, 5)->make());
    	});

        return true;
    }
}
