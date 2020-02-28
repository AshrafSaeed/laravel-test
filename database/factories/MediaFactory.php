<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'name' => Str::snake($faker->firstName.'_'.$faker->lastName),
        'path' =>$faker->imageUrl,
    ];
});
