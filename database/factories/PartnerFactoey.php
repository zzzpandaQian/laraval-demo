<?php

use Faker\Generator as Faker;
use Faker\Provider\en_US\Text;


$factory->define(App\Models\Partner::class, function (Faker $faker) {

    $image = $faker->randomElement([
        "http://cdn001.eastyun.net/demo/pic01-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic02-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic03-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic04-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic05-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic06-140x140.jpg",
    ]);
    return [
        'title'           => $faker->name,
        'image'           => $image,
        'description'     => $faker->realText(),
        'status'          => $faker->randomElement([0,1]),
    ];
});
