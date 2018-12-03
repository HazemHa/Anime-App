<?php

use Faker\Generator as Faker;

$factory->define(App\DownloadsServer::class, function (Faker $faker) {
    return [
        //
        'episode_id'=> function () {
            return App\Episode::inRandomOrder()->get()->first()->id;
        },
        'server_name'=>$faker->lastName,
        'episode_link'=> $faker->imageUrl($width = 640, $height = 480),
        'valid'=> $faker->randomElement($array = array(true,false)),
    ];
});
