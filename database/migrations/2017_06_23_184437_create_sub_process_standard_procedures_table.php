<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubProcessStandardProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_process_standard_procedures', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_process_id')->unsigned();
            $table->foreign('sub_process_id')->references('id')->on('sub_processes')->onDelete('cascade');
            $table->integer('procedure_id')->unsigned();
            $table->foreign('procedure_id')->references('id')->on('standard_procedures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sub_process_standard_procedures');
    }
}
