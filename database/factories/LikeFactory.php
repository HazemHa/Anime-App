<?php

use Faker\Generator as Faker;

$factory->define(App\Like::class, function (Faker $faker) {
    return [
        //
        
        'user_id'=>function () {
            return factory(App\User::class)->create()->id;

        },
        'likestable_id'=> function () use ($faker) {
            if ($faker->randomElement($array = array(true, false))) {
                return factory(App\Group::class)->create()->id;
            } else if($faker->randomElement($array = array(true, false))){
                return factory(App\Episode::class)->create()->id;
            }
                return factory(App\Comment::class)->create()->id;
            
        },
        'likestable_type'=> $faker->randomElement($array = array('App\Episode', 'App\Group')),
        
    ];
});
