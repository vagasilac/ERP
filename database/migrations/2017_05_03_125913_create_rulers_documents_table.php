<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulersDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rulers_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rulers_id')->unsigned();
            $table->foreign('rulers_id')->references('id')->on('rulers')->onDelete('cascade');
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
        Schema::drop('rulers_documents');
    }
}
