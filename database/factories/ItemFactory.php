<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;
use App\Brand;
use App\Type;
use App\Category;

$factory->define(Item::class, function (Faker $faker) {
    $brands = Brand::pluck('id');
    $types = Type::pluck('id');
    $categories = Category::pluck('id');
    $name = $faker->word.str_random(5);
    return [
        'brand_id' => $faker->randomElement($brands),
        'type_id' => $faker->randomElement($types),
        'category_id' => $faker->randomElement($categories),
        'name' => $name,
        'slug' => str_slug($name),
        'description' => $faker->paragraph,
        'srp' => '5000.00',
        'cost' => '5000.00',
        'qty' => '25'
    ];
});
