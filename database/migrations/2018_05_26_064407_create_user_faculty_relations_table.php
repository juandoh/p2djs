<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFacultyRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_faculty_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->unique();
            $table->integer('role');
            $table->integer('faculty_id')->unsigned()->index()->unique();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('faculty_id')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_faculty_relations');
    }
}
