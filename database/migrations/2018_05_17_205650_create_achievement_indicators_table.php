<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_indicators', function (Blueprint $table) {
            //id,learningO,name,detail
            $table->increments('id');
            //$table->integer('course')->unsigned()->index();
            $table->integer('learningO')->unsigned()->index();
            $table->string('name')->unique();
            $table->string('detail');            
            $table->timestamps();
            //$table->foreign('course')->references('id')->on('courses');
            $table->foreign('learningO')->references('id')->on('learning_outcomes')->onDelete('cascade');
        });


        /*Schema::table('achievement_indicators', function (Blueprint $table) {
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
        Schema::dropIfExists('achievement_indicators');
    }
}
