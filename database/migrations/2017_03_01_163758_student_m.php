<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('about', 500)->nullable();
            $table->date('dob')->nullable();
            $table->string('file',50)->nullable();
            $table->string('photo',50)->nullable();
            $table->integer('book')->nullable();
            $table->string('profile_link', 500)->nullable();
            $table->integer('gender')->nullable();
            $table->string('email',50)->nullable();
            $table->integer('age')->nullable();
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('student');
    }
}
