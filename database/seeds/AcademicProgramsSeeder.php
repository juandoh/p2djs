<?php

use Illuminate\Database\Seeder;

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
