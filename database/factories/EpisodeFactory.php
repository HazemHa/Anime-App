<?php

use Faker\Generator as Faker;

$factory->define(App\Episode::class, function (Faker $faker) {
    return [
        //
        
        'group_id'=> function () {
            return App\Group::inRandomOrder()->get()->first()->id;
        },
        'uploaded_by'=> function () {
            return App\User::inRandomOrder()->get()->first()->id;
        },
        'number'=>$faker->unique()->numberBetween($min = 1, $max = 66),
        'description'=>$faker->sentence($nbWords = 15, $variableNbWords = true),
        'views'=>$faker->numberBetween($min = 100, $max = 2000),
        
    ];
});
