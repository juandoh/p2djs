<?php

use Faker\Generator as Faker;

$factory->define(App\Schools::class, function (Faker $faker) {
	return [
        'name'=>$faker->unique()->sentence(3),
        'faculty'=>$faker->numberBetween(1,10),
        'detail'=>$faker->text(191)
    ];
});
