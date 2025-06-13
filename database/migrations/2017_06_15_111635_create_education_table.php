<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nr');
            $table->text('description');
            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->date('planned_start_date')->nullable();
            $table->date('planned_finish_date')->nullable();
            $table->date('accomplished_start_date')->nullable();
            $table->date('accomplished_finish_date')->nullable();
            $table->boolean('trainer_confirmed');
            $table->enum('rating_mode', ['exam', 'questions', 'practical_work']);
            $table->enum('repeat', ['yes', 'no']);
            $table->integer('certificate_id')->unsigned()->nullable();
            $table->foreign('certificate_id')->references('file_id')->on('user_documents')->onDelete('set null');
            $table->string('certificate_nr');
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
        Schema::drop('education');
    }
}
