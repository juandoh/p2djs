<?php

use Faker\Generator as Faker;

$factory->define(App\Faculties::class, function (Faker $faker) {
    return [
        'name'=>$faker->unique()->sentence(3),
        'detail'=>$faker->text(191)
    ];
});
