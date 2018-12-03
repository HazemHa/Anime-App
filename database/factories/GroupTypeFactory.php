<?php

use Faker\Generator as Faker;
use App\GroupType;
$factory->define(App\GroupType::class, function (Faker $faker) {
    $data = GroupType::pluck('name');
    return [
        //
        'name' => $faker->unique()->randomElement($array = array('Manga', 'Movies', 'Collections')),
        'description' => $faker->sentence($nbWords = 15, $variableNbWords = true),
    ];
});
