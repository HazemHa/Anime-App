<?php

use Faker\Generator as Faker;

$factory->define(App\Favorite::class, function (Faker $faker) {
    return [
        //
        
        'user_id'=> function () {
            return factory(App\User::class)->create()->id;

        },
        'favoritetable_id'=> function () use ($faker) {
            if($faker->randomElement($array = array(true,false))){
                return factory(App\Group::class)->create()->id;
            }
                return factory(App\Episode::class)->create()->id;
            
        },
        'favoritetable_type'=>$faker->randomElement($array = array('App\Episode', 'App\Group', 'App\Comment')),
        
    ];
});
