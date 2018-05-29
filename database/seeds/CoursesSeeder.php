<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Courses::class,20)->create();
    }
}
