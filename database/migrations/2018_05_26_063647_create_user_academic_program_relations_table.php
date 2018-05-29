<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAcademicProgramRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_academic_program_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->unique();
            $table->integer('role');
            $table->integer('program_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('program_id')->references('id')->on('academic_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_academic_program_relations');
    }
}
