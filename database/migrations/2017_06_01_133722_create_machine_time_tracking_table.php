<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineTimeTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_time_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->unsigned()->nullable();
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('set null');
            $table->string('operation');
            $table->string('frequency')->nullable();
            $table->enum('type', ['start', 'pause', 'stop']);
            $table->text('note');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('machine_time_tracking');
    }
}
