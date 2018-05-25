<?php

use Faker\Generator as Faker;

$factory->define(App\Courses::class, function (Faker $faker) {
	//"name", "credits", "mhours", "ihours", "ctype", 
	//"precourses", "valuable", "qualifiable" ,"p_academico","semester"
	$credits=$faker->numberBetween(2,4);
	$semhours = $credits*3;
	$mhours=0;
	$ihours=0;
	do{
		$mhours = $faker->numberBetween(3,4);
		$ihours = $faker->numberBetween(3,$semhours);
	}while($mhours+$ihours != $semhours or $mhours>$ihours);

    $validTeacher = false;
    do{
        $userId = $faker->numberBetween(1,20);
        if(App\User::find($userId)->role == 1){
            $validTeacher = true;
        }
    }while(!$validTeacher);



    return [
        'name'=>$faker->unique()->sentence(3),
        'credits'=>$credits,
        'mhours'=>$mhours,
        'ihours'=>$ihours,
        'ctype'=>$faker->numberBetween(1,4),
        'precourses'=>$faker->sentence(5),
        'valuable'=>$faker->numberBetween(0,1),
        'qualifiable'=>$faker->numberBetween(0,1),
        'p_academico'=>$faker->numberBetween(1,10),
        'semester'=>$faker->numberBetween(1,10),
        'created_by'=>$userId
    ];
});
