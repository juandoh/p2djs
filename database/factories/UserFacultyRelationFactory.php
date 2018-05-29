<?php

use Faker\Generator as Faker;

$factory->define(App\UserFacultyRelation::class, function (Faker $faker) {
	do{
		$user_id=$faker->unique()->numberBetween(1,33);
		$alreadyProgram = !is_null(App\UserAcademicProgramRelation::where('user_id',$user_id)->first());
		printf("id:%s already:%s\n",$user_id,$alreadyProgram);
	}while($alreadyProgram);
    return [
        'user_id'=>$user_id,
        'role'=>3,
    ];
});
