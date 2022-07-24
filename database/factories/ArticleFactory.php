<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'article_text' => $faker->text(500),
        //'user_id' => rand(1,50),
        //'user_id' => \App\User::inRandomOrder()->first()->id,
        'user_id' => factory(\App\User::create()->id),
    ];
});
