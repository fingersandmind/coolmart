<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $names = ['Mitsubishi', 'Fujidenzo', 'Kelvinator', 'Panasonic', 'Fujitso', 'Samsung', 'LG'];
    $name = $faker->randomElement($names).str_random(3);
    return [
        'name'          => $name,
        'slug'          => str_slug($name),
        'description'   => $faker->sentence,
        'logo'          => 'logo.jpeg'
    ];
});
