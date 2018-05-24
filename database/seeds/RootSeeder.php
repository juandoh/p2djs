<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RootSeeder extends Seeder
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
            'fullname'=>'root',
            'shortname'=>'root',
            'email'=>'root@admin.com',
            'password'=>bcrypt('root'),
            'role'=>0
        ]);
    }
}
