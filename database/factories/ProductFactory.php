
<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3, true),
        'description' => $faker->sentence(3, true),
        'vendor_id' => factory('App\Models\Vendor'),
        'price' => random_int(100,10000),
    ];
});
