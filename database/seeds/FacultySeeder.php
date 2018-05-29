<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Faculties::class,10)->create();
    }
}
