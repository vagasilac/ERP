<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('G', 5, 2)->nullable();
            $table->decimal('AL', 5, 2)->nullable();
            $table->boolean('ml_6')->nullable();
            $table->boolean('ml_12')->nullable();
            $table->boolean('ml_12_1')->nullable();
            $table->boolean('DC01')->nullable();
            $table->boolean('S235')->nullable();
            $table->boolean('S275')->nullable();
            $table->boolean('S355')->nullable();
            $table->boolean('S460')->nullable();
            $table->boolean('DIN1025_1')->nullable();
            $table->boolean('DIN1025_5')->nullable();
            $table->boolean('EN10210_2')->nullable();
            $table->boolean('EN10210_3')->nullable();
            $table->boolean('EN10210_4')->nullable();
            $table->boolean('EN10210_5')->nullable();
            $table->boolean('EN10210_6')->nullable();
            $table->boolean('EN10210_7')->nullable();
            $table->boolean('Euronorm19_57')->nullable();
            $table->decimal('thickness', 5, 2)->nullable();
            $table->decimal('price', 5, 2)->nullable();
            $table->integer('M')->nullable();
            $table->decimal('consumption', 5, 2)->nullable();
            $table->string('material_group', 5, 2)->nullable();
            $table->string('type', 50);
            $table->string('unit', 10);
            $table->decimal('coefficient', 5, 2)->nullable();
            $table->text('info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_materials');
    }
}
