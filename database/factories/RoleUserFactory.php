<?php

use Faker\Generator as Faker;
use App\RoleUser;

$factory->define(App\RoleUser::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
    ];
});
