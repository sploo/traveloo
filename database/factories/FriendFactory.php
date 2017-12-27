<?php

use Faker\Generator as Faker;

use App\User;

$factory->define(App\Friend::class, function (Faker $faker) {
    $users = User::all();

    $user_id = $faker->numberBetween (0, count($users));
    $friend_id = $faker->numberBetween (0, count($users));
    $status = $faker->numberBetween(1,2);

    return [
        'user_id' => $user_id,
        'friend_id' => $friend_id,
        'status' => $status
    ];
});
