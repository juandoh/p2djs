<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home/{id?}','Session\ViewsController@index')->name('home');
Route::get('/home/{id?}/{createWhat?}','Session\RootController@index');
Route::get('/user/{id?}','Session\RootController@editUser');
Route::get('/user/{id?}/{editWhat?}','Session\RootController@editUser');


$arr = [
    'Faculty'=> 'CRUD\Faculties',
    'School' => 'CRUD\Schools',
    'Program'=> 'CRUD\AcademicPrograms',
    'Course' => 'CRUD\Courses',
    'Competence'=> 'CourseDesign\CourseCompetences',
    'Outcome'   => 'CourseDesign\LearningOutcomes',
    'Indicator' => 'CourseDesign\AchievementIndicators'
];
$soft =[
    'Faculty','School','Program'
];

foreach($arr as $name=>$control){
    Route::get('/'.strtolower($name).'/{id}',$control.'Controller@showEdit');
    Route::post('create'.$name,$control.'Controller@create')->name('create'.$name);
    Route::post('update'.$name,$control.'Controller@update')->name('update'.$name);
    Route::post('delete'.$name.'/{id}',$control.'Controller@delete')->name('delete'.$name);
    if(in_array($name,$soft)){
        Route::post('enable'.$name.'/{id}',$control.'Controller@enable')->name('enable'.$name);
    }
}

//##########################################TEST################
Route::get('/post','Testing\PostController@show')->name('post');
Route::post('/post','Testing\PostController@store');
