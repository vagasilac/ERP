<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractRegisterDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_register_documents', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_register_id')->unsigned();
            $table->foreign('contract_register_id')->references('id')->on('contract_registers')->onDelete('cascade');
            $table->string('name');
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_register_documents');
    }
}
