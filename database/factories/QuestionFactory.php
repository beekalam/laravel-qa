<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Question;
use App\User;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title'       => rtrim($faker->sentence(rand(5, 10)), "."),
        'body'        => $faker->paragraphs(rand(3, 7), true),
        'views'       => rand(0, 10),
        // 'answers_count' => rand(0, 10),
        // 'votes_count' => rand(-3, 10),
        'user_id'     => function () {
            return User::all()->random();
        }
    ];
});
