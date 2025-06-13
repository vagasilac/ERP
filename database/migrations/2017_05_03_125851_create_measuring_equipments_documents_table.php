<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuringEquipmentsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measuring_equipments_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('measuring_equipments_id')->unsigned();
            $table->foreign('measuring_equipments_id')->references('id')->on('measuring_equipments')->onDelete('cascade');
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
        Schema::drop('measuring_equipments_documents');
    }
}
