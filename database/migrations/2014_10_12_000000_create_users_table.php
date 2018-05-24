<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //id,fullname,shortname,email,password,role,enabled
            $table->increments('id');
            $table->string('fullname');
            $table->string('shortname')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('role');
            //$table->boolean('enabled')->default(true); //soft delete
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
