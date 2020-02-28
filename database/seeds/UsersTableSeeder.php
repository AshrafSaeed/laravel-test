<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        App\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@laravel-test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(10),
            'is_active' => true
        ]);

        return factory('App\User'::class, 5)->create();
        
    }
}
