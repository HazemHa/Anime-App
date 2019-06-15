<?php

use Faker\Generator as Faker;

$factory->define(App\Rating::class, function (Faker $faker) {
    return [
        //
        'user_id'=>function () {
            return factory(App\User::class)->create()->id;
        }, 
        'count'=> $faker->numberBetween($min = 1, $max = 5),

        'rating_id'=> function () use ($faker) {
            if ($faker->randomElement($array = array(true, false))) {
                return factory(App\Group::class)->create()->id;
            } else if ($faker->randomElement($array = array(true))) {
                return factory(App\Episode::class)->create()->id;
            }

        },
         'rating_type'=>$faker->randomElement ($array = array ('App\Episode', 'App\Group')),

    ];
});
