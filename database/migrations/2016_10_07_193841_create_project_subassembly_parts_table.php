<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSubassemblyPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_subassembly_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('subassembly_id')->unsigned();
            $table->foreign('subassembly_id')->references('id')->on('project_subassemblies')->onDelete('cascade');
            $table->string('material_name')->nullable();
            $table->integer('material_id')->unsigned()->nullable();
            $table->foreign('material_id')->references('id')->on('settings_materials')->onDelete('set null');
            $table->string('standard_name')->nullable();
            $table->integer('standard_id')->unsigned()->nullable();
            $table->foreign('standard_id')->references('id')->on('settings_material_standards')->onDelete('set null');
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_subassembly_parts');
    }
}
