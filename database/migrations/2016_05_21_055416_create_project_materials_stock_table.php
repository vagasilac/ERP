<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMaterialsStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_materials_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material_id')->unsigned()->nullable();
            $table->foreign('material_id')->references('id')->on('settings_materials')->onDelete('set null');
            $table->integer('standard_id')->unsigned()->nullable();
            $table->foreign('standard_id')->references('id')->on('settings_material_standards')->onDelete('set null');
            $table->integer('certificate_id')->unsigned()->nullable();
            $table->foreign('certificate_id')->references('id')->on('settings_material_standards')->onDelete('set null');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->integer('pieces')->default(1);
            $table->string('location')->nullable()->default(NULL);
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
        Schema::drop('project_materials_stock');
    }
}
