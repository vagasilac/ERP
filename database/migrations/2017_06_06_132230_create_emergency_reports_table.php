<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_reports', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('description', ['fire', 'spill', 'explosion', 'damage', 'weather_phenomena', 'quake', 'other']);
            $table->text('other_description');
            $table->dateTime('process_date');
            $table->string('location');
            $table->text('cause');
            $table->text('consequenc');
            $table->text('plan');
            $table->text('take_action');
            $table->text('intervention_team_plan');
            $table->text('requirements_for_intervention');
            $table->text('required_measures');
            $table->integer('responsibility_user_id')->unsigned();
            $table->foreign('responsibility_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('required_measures_deadlin');
            $table->enum('modify_the_emergency_plan', ['yes', 'no']);
            $table->text('revision_responsible_emergency_plan');
            $table->date('revision_responsible_emergency_plan_deadlin');
            $table->integer('elaborate_user_id')->unsigned();
            $table->foreign('elaborate_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('verified');
            $table->dateTime('verified_date_time');
            $table->integer('verified_user_id')->unsigned()->nullable();
            $table->foreign('verified_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('approved');
            $table->dateTime('approved_date_time');
            $table->integer('approved_user_id')->unsigned()->nullable();
            $table->foreign('approved_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('emergency_reports');
    }
}
