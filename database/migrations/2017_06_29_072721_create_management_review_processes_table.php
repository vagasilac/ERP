<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementReviewProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_review_processes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('management_review_id')->unsigned();
            $table->foreign('management_review_id')->references('id')->on('management_review_meetings')->onDelete('cascade');
            $table->integer('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('set null');
            $table->text('purpose_of_the_process');
            $table->text('process_objectives');
            $table->text('current_status');
            $table->text('target');
            $table->enum('realised', ['yes', 'no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('management_review_processes');
    }
}
