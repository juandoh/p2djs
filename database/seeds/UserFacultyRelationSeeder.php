<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserFacultyRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\UserFacultyRelation::class,10)->create();
    }
}
