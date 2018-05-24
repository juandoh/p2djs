<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {    
    $name = $faker->unique()->name;
    return [
        'fullname' => $name,
        'shortname' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'), // secret
        'role' => rand(1,3),
        'remember_token' => str_random(10),
    ];
});
