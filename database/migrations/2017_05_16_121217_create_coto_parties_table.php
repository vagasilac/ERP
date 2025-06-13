<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_parties', function(Blueprint $table) {
            $table->increments('id');
            $table->string('interested_party');
            $table->enum('int_ext', ['external', 'internal']);
            $table->text('reason_for_inclusion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coto_parties');
    }
}
