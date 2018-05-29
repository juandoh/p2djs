<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AcademicProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AcademicPrograms::class,10)->create();
    }
}
