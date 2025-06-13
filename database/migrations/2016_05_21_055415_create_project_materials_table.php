<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('material_id')->unsigned()->nullable();
            $table->foreign('material_id')->references('id')->on('settings_materials')->onDelete('set null');
            $table->integer('standard_id')->unsigned()->nullable();
            $table->foreign('standard_id')->references('id')->on('settings_material_standards')->onDelete('set null');
            $table->integer('certificate_id')->unsigned()->nullable();
            $table->foreign('certificate_id')->references('id')->on('settings_material_standards')->onDelete('set null');
            $table->integer('material_no')->unsigned()->nullable();
            $table->string('net_size')->nullable();
            $table->string('size')->nullable();
            $table->decimal('net_quantity', 10, 2)->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->integer('pieces')->default(1);
            $table->integer('canceled')->unsigned()->default(0);
            $table->integer('order_request')->unsigned()->default(0);
            $table->integer('sort')->unsigned()->default(0);
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
        Schema::drop('project_materials');
    }
}
