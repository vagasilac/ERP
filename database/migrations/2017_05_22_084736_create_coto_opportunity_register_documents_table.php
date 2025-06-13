<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoOpportunityRegisterDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_opportunity_register_documents', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coto_opp_reg_id')->unsigned();
            $table->foreign('coto_opp_reg_id')->references('id')->on('coto_opportunity_registers')->onDelete('cascade');
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
        Schema::drop('coto_opportunity_register_documents');
    }
}
