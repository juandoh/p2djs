<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            //"name", "credits", "mhours", "ihours", "ctype", "precourses", "valuable", "qualifiable" ,"program_id"
            $table->increments('id');
            $table->string('name');
            $table->smallInteger('credits');
            $table->smallInteger('mhours');
            $table->smallInteger('ihours');
            $table->smallInteger('ctype');            
            $table->boolean('valuable')->default(1);
            $table->boolean('qualifiable')->default(1);            
            $table->integer('program_id')->unsigned()->index();
            $table->smallInteger('semester');
            $table->integer('created_by')->unsigned()->index();
            $table->timestamps();
            $table->foreign('program_id')
                    ->references('id')
                    ->on('academic_programs');
            $table->foreign('created_by')
                    ->references('id')
                    ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
