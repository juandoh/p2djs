<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Schools::class,10)->create();
    }
}
