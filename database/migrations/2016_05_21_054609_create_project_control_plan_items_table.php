<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectControlPlanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_control_plan_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('frequency')->nullable();
            $table->string('measurement_tool')->nullable();
            $table->string('visual_control')->nullable();
            $table->string('performed_by')->nullable();
            $table->string('registered_in')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('project_control_plan_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_control_plan_items');
    }
}
