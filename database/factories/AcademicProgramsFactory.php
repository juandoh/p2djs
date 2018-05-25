<?php

use Faker\Generator as Faker;

$factory->define(App\AcademicPrograms::class, function (Faker $faker) {
    return [
        'name'=>$faker->unique()->sentence(3),
        'school'=>$faker->numberBetween(1,10),
        'semesters'=>$faker->numberBetween(1,10),
        'credits'=>$faker->numberBetween(50,150)
    ];
});
