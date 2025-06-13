<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputsOutputsRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs_outputs_register', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('number')->nullable();
            $table->string('description')->nullable();
            $table->string('receiver')->nullable();
            $table->string('target')->nullable();
            $table->date('received_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('notice_number')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inputs_outputs_register');
    }
}
