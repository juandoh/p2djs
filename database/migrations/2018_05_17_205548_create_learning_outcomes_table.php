<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningOutcomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_outcomes', function (Blueprint $table) {
            //id,competence,name,detail
            $table->increments('id');
            //$table->integer('course')->unsigned()->index();
            $table->integer('competence')->unsigned()->index();
            $table->string('name')->unique();
            $table->string('detail');            
            $table->timestamps();
            //$table->foreign('course')->references('id')->on('courses');
            $table->foreign('competence')->references('id')->on('course_competences')->onDelete('cascade');
        });

        /*Schema::table('learning_outcomes', function (Blueprint $table) {
            $table->foreign('course')->references('id')->on('courses');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_outcomes');
    }
}
