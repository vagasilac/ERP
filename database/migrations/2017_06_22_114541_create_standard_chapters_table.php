<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_chapters', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('standard_id')->unsigned();
            $table->foreign('standard_id')->references('id')->on('standards')->onDelete('cascade');
            $table->string('chapter_nr');
            $table->string('chapter_title');
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
        Schema::drop('standard_chapters');
    }
}
