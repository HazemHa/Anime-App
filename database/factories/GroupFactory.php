<?php

use Faker\Generator as Faker;
use App\GroupType;
use App\User;
$factory->define(App\Group::class, function (Faker $faker) {
    return [
        //
        'writtenBy'=> function () {
            return User::inRandomOrder()->get()->first()->id;
        },
        'group_type_id'=> function () {
            return GroupType::inRandomOrder()->get()->first()->id;
        },
        
        'name'=> $faker->name,
        'description'=> $faker->paragraph,
        'image'=> $faker->imageUrl($width = 640, $height = 480),

    ];
});
