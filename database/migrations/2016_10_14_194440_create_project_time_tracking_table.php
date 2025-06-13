<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTimeTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_time_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->integer('subassembly_id')->unsigned()->nullable();
            $table->foreign('subassembly_id')->references('id')->on('project_subassemblies')->onDelete('set null');
            $table->enum('type', ['start', 'pause', 'stop']);
            $table->integer('completed_items_no')->unsigned()->nullable();
            $table->integer('in_process_item_percentage')->unsigned()->nullable();
            $table->string('operation_name');
            $table->string('operation_slug');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::drop('project_time_tracking');
    }
}
