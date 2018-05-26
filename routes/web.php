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
Route::post('/', function () {
    return redirect('/');
})->name('dump');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// #############################Registration Routes...###################################
Route::get('register',function(){return redirect()->back();});
Route::post('register', 'Auth\RegisterController@registerUser')->name('register');
Route::post('validateUser','Auth\RegisterController@validateField')->name('check');
Route::post('updateUser','Auth\RegisterController@updateUser')->name('updateUser');
Route::post('deleteUser/{id?}','Auth\RegisterController@deleteUser');
Route::post('enableUser/{id?}','Auth\RegisterController@enableUser');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//#######################################################################################

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

Route::get('/design/course/{id}','CRUD\CoursesController@showDesigner');
Route::get('/info/course/{id}','CRUD\CoursesController@showInfo');

//##########################################TEST################
Route::get('/post','Testing\PostController@show')->name('post');
Route::post('/post','Testing\PostController@store');
Route::get('/post/input','Testing\PostController@input');
