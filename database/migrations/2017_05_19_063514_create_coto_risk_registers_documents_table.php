<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoRiskRegistersDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_risk_registers_documents', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coto_risk_register_id')->unsigned();
            $table->foreign('coto_risk_register_id')->references('id')->on('coto_risk_registers')->onDelete('cascade');
            $table->string('name')->nullable();
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
        Schema::drop('coto_risk_registers_documents');
    }
}
