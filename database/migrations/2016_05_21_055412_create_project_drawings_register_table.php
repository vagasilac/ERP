<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDrawingsRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_drawings_register', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('drawing_id')->unsigned()->nullable();
            $table->foreign('drawing_id')->references('id')->on('project_drawings')->onDelete('set null');
            $table->boolean('reception')->default(0);
            $table->datetime('reception_date')->nullable();
            $table->integer('reception_user_id')->unsigned()->nullable();
            $table->foreign('reception_user_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('distribution')->default(0);
            $table->datetime('distribution_date')->nullable();
            $table->integer('distribution_user_id')->unsigned()->nullable();
            $table->foreign('distribution_user_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('collection')->default(0);
            $table->datetime('collection_date')->nullable();
            $table->integer('collection_user_id')->unsigned()->nullable();
            $table->foreign('collection_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_drawings_register');
    }
}
