<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_competences', function (Blueprint $table) {
            //id,course,name,detail      
            $table->increments('id');
            $table->integer('course')->unsigned()->index();
            $table->string('name')->unique();
            $table->string('detail');            
            $table->timestamps();
            $table->foreign('course')->references('id')->on('courses')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_competences');
    }
}
