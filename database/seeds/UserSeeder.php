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
            'password'=>bcrypt('teacher')
        ]);

        //id,fullname,shortname,email,password,role,enabled
        DB::table('users')->insert([
            'fullname'=>'plan director',
            'shortname'=>'director',
            'email'=>'director@2djs.com',
            'password'=>bcrypt('director')
        ]);

        //id,fullname,shortname,email,password,role,enabled
        DB::table('users')->insert([
            'fullname'=>'faculty dean',
            'shortname'=>'dean',
            'email'=>'dean@2djs.com',
            'password'=>bcrypt('dean')            
        ]);

        DB::table('user_admin_relations')->insert(['user_id'=>1,'role'=>0]);
        DB::table('user_academic_program_relations')->insert(['user_id'=>2,'role'=>1,'program_id'=>1]);   
        DB::table('user_academic_program_relations')->insert(['user_id'=>3,'role'=>2,'program_id'=>1]);
        DB::table('user_faculty_relations')->insert(['user_id'=>4,'role'=>3,'faculty_id'=>1]);

        //factory(App\User::class,30)->create();
    }
}
