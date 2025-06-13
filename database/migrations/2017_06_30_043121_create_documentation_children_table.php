<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentationChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentation_children', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('documentation_id')->unsigned();
            $table->foreign('documentation_id')->references('id')->on('documentations')->onDelete('cascade');
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
        Schema::drop('documentation_children');
    }
}
