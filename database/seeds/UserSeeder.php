<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id,fullname,shortname,email,password,role,enabled
        DB::table('users')->insert([
            'fullname'=>'teacher',
            'shortname'=>'teacher',
            'email'=>'teacher@2djs.com',
            'password'=>bcrypt('teacher'),
            'role'=>1            
        ]);

        //id,fullname,shortname,email,password,role,enabled
        DB::table('users')->insert([
            'fullname'=>'plan director',
            'shortname'=>'director',
            'email'=>'director@2djs.com',
            'password'=>bcrypt('director'),
            'role'=>2            
        ]);

        //id,fullname,shortname,email,password,role,enabled
        DB::table('users')->insert([
            'fullname'=>'faculty dean',
            'shortname'=>'dean',
            'email'=>'dean@2djs.com',
            'password'=>bcrypt('dean'),
            'role'=>3            
        ]);

        factory(App\User::class,30)->create();
    }
}
