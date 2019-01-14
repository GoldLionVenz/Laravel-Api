<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Serie::class, function(Faker $faker){
    return [
        'id'=>str_random(20),
        'title'=>$faker->realText(random_int(15,20)),
        'plot'=>$faker->realText(random_int(350,600)),
        'poster'=>'/storage/posters/'.random_int(1,21).'.jpg',
        'imdbRating'=>random_int(6,9),
        'created_at'=>$faker->dateTimeThisYear,
    ];
});

$factory->define(App\Season::class, function(Faker $faker){
    return [
        'poster'=>'/storage/posters/'.random_int(1,21).'.jpg',
        'banner'=>'/storage/banners/'.random_int(1,11).'.jpg',
        'created_at'=>$faker->dateTimeThisYear
    ];
});
