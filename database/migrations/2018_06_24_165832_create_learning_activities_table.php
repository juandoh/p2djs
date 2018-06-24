<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("learning_outcome")->unsigned()->index();
            $table->string("detail");
            $table->timestamps();
            $table->foreign("learning_outcome")->references("id")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_activities');
    }
}
