<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectQualityControlDrawingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_quality_control_drawings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('drawing_id')->unsigned();
            $table->foreign('drawing_id')->references('id')->on('project_drawings')->onDelete('cascade');
            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_quality_control_drawings');
    }
}
