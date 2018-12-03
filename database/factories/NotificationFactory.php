<?php

use Faker\Generator as Faker;

$factory->define(App\Notification::class, function (Faker $faker) {
    return [
        //
        'sender_id'=> function () {
            return App\User::inRandomOrder()->get()->first()->id;
        },
        'receiver_id'=> function () {
            return factory(App\User::class)->create()->id;
        },
        'body'=> $faker->paragraph
    ];
});
