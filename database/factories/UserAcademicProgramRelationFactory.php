<?php

use Faker\Generator as Faker;

$factory->define(App\UserAcademicProgramRelation::class, function (Faker $faker) {
    do{
		$user_id=$faker->unique()->numberBetween(1,33);
		$alreadyProgram = !is_null(App\UserFacultyRelation::where('user_id',$user_id)->first());
	}while($alreadyProgram);
    return [
        'user_id'=>$user_id,
        'role'=>$faker->numberBetween(1,2),
    ];
});
