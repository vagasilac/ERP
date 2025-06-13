<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapaResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_results', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('capa_id')->unsigned();
            $table->foreign('capa_id')->references('id')->on('capas')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('result', ['pass', 'fail']);
            $table->text('notes_and_justification');
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
        Schema::drop('capa_results');
    }
}
