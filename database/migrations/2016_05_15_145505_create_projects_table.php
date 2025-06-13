<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->integer('primary_responsible')->unsigned()->nullable();
            $table->foreign('primary_responsible')->references('id')->on('users')->onDelete('set null');
            $table->integer('secondary_responsible')->unsigned()->nullable();
            $table->foreign('secondary_responsible')->references('id')->on('users')->onDelete('set null');
            $table->date('deadline')->nullable();
            $table->text('management_note')->nullable();
            $table->string('primary_code', 10)->nullable();
            $table->string('secondary_code', 10)->nullable();
            $table->string('production_code', 30)->nullable();
            $table->integer('production_no')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->default(1);
            $table->string('status', 50)->nullable();
            $table->enum('type', ['offer', 'work', 'executed'])->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('projects')->onDelete('set null');
            $table->tinyInteger('version')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
