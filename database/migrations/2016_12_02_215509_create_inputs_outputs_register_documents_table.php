<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputsOutputsRegisterDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs_outputs_register_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('io_register_id')->unsigned();
            $table->foreign('io_register_id')->references('id')->on('inputs_outputs_register')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->enum('type', ['input', 'output']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inputs_outputs_register_documents');
    }
}
