<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'city_id' => $faker->text(),
        'token' => $faker->text(),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'deleted_at' => null,
        'language' => 'en',
    ];
});

/* @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Source::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->sentence,
        'user_id' => $faker->randomNumber(5),
        'source' => $faker->sentence,
        'map_items' => $faker->sentence,
        'map_id' => $faker->sentence,
        'map_title' => $faker->sentence,
        'map_description' => $faker->sentence,
        'map_image' => $faker->sentence,
        'map_date' => $faker->sentence,
        'map_date_format' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
    ];
});

