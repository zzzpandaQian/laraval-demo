<?php

use App\Models\NewsCategory;
use Faker\Generator as Faker;
use Faker\Provider\en_US\Text;

$factory->define(App\Models\News::class, function (Faker $faker) {

    $image = $faker->randomElement([
        "http://cdn001.eastyun.net/demo/pic01-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic02-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic03-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic04-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic05-140x140.jpg",
        "http://cdn001.eastyun.net/demo/pic06-140x140.jpg",
    ]);

    $news_category = NewsCategory::query()->where('status', 1)->inRandomOrder()->first();
    return [
        'title'            => $faker->name,
        'news_category_id' => $news_category->id,
        'image'            => $image,
        'content'          => $faker->realText(),
        'status'           => $faker->randomElement([0,1]),
    ];
});
