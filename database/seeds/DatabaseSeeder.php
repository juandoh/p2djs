<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RootSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(SchoolsSeeder::class);
        $this->call(AcademicProgramsSeeder::class);

        $this->call(UserSeeder::class);
        //$this->call(UserFacultyRelationSeeder::class);
        //$this->call(UserProgramRelationSeeder::class);
        $this->call(CoursesSeeder::class);
    }
}
