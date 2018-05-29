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
            $table->integer('competence')->unsigned()->index();
            $table->string('name')->unique();
            $table->string('detail');            
            $table->timestamps();            
            $table->foreign('competence')->references('id')->on('course_competences')->onDelete('cascade');
        });
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
