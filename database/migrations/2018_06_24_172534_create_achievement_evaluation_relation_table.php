<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementEvaluationRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_evaluation_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("achievement_id")->unsigned()->index();
            $table->integer("activity_id")->unsigned()->index();
            $table->timestamps();
            $table->foreign("achievement_id")->references("id")->on("achievement_indicators");
            $table->foreign("activity_id")->references("id")->on("evaluation_activities");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievement_evaluation_relation');
    }
}
