<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapaPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_plans', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('capa_id')->unsigned();
            $table->foreign('capa_id')->references('id')->on('capas')->onDelete('cascade');
            $table->text('root_cause_of_problem');
            $table->text('action_plan');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('capa_plans');
    }
}
