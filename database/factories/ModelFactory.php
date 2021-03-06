<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(
    App\Models\User::class, function (Faker\Generator $faker) {
        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName,
            'email' => 'johndeo@gmail.com',
            'password' => '$2y$10$YcUVoDjHkSAm1gSoSl9vsObfe2cHi/qob/oK9aAPA59TYFrQ6.bxS',
            'username' => $faker->username,
            'role' => 'user'
        ];
    }
);

$factory->define(
    App\Models\Album::class, function (Faker\Generator $faker) {
        return [
            'name' => $faker->title,
            'description' => $faker->text(50),
            'user_id' => 1,
        ];
    }
);


$factory->define(
    App\Models\Song::class, function (Faker\Generator $faker) {
        return [
            'name' => $faker->title,
            'description' => $faker->text(50),
            'url' => 'audio/mama.mp3',
            'album_id' => 1,
            'genre' => 'electro'
        ];
    }
);

$factory->define(
    App\Models\Playlist::class, function (Faker\Generator $faker) {
        return [
            'name' => $faker->title,
            'description' => $faker->text(50),
            'user_id' => 1
        ];
    }
);