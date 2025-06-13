<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('revision');
            $table->date('date');
            $table->string('type');
            $table->string('link')->nullable();
            $table->enum('link_type', ['pdf', 'url']);
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
        Schema::drop('documentations');
    }
}
