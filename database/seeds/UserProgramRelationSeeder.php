<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserProgramRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\UserAcademicProgramRelation::class,20)->create();
    }
}
