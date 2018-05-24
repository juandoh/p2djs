<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_programs', function (Blueprint $table) {
            //"name", "school","faculty", "semester", "credits"
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('school')->unsigned()->index();//foreign id
            //$table->integer('faculty')->unsigned()->index();//foreign id
            $table->smallInteger('semesters');//#of semesters
            $table->smallInteger('credits');
            $table->softDeletes();     
            $table->timestamps();
        });

        Schema::table('academic_programs', function (Blueprint $table) {
            $table->foreign('school')->references('id')->on('schools');
            //$table->foreign('faculty')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_programs');
    }
}
