<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubProcessStandardChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_process_standard_chapters', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_process_id')->unsigned();
            $table->foreign('sub_process_id')->references('id')->on('sub_processes')->onDelete('cascade');
            $table->integer('standard_chapter_id')->unsigned();
            $table->foreign('standard_chapter_id')->references('id')->on('standard_chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sub_process_standard_chapters');
    }
}
