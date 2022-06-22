<?php

use Faker\Generator as Faker;
use Faker\Provider\en_US\Text;

$factory->define(App\Models\Faq::class, function (Faker $faker) {
    return [
        'title'           => $faker->name,
        'description'     => $faker->realText(),
        'status'          => $faker->randomElement([0,1]),
    ];
});
