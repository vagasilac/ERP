<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsMaterialStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_material_standards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('EN')->nullable();
            $table->string('DIN_SEW')->nullable();
            $table->decimal('number', 6, 4)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_material_standards');
    }
}
