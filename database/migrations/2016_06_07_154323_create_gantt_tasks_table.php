<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGanttTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gantt_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->string('operation')->nullable();
            $table->datetime('start_date');
            $table->integer('duration')->default(0);
            $table->float('progress')->default(0);
            $table->double('sortorder')->default(0);
            $table->integer('parent')->default(0);
            $table->datetime('deadline')->nullable();
            $table->datetime('planned_start')->nullable();
            $table->datetime('planned_end')->nullable();
            $table->datetime('end_date');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gantt_tasks');
    }
}
