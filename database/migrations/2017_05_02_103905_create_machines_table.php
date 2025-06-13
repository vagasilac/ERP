<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('inventory_no')->unsigned();
            $table->string('source')->nullable();
            $table->smallInteger('manufacturing_year')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->decimal('power', 5, 2)->nullable();
            $table->string('observations')->nullable();
            $table->integer('operation_id')->unsigned()->nullable();
            $table->foreign('operation_id')->references('id')->on('project_calculations_settings')->onDelete('set null');
            $table->enum('maintenance_log', ['abkant', 'electrical_welding_apparatus', 'tig_mig_mag_welding_machine', 'disk_saws', 'cutting_saw', 'stinging_scissors', 'drilling', 'general', 'guillotine', 'bending', 'rotary_table', 'double_fixed_sander', 'presser', 'roll_trained', 'chamfering', 'polishing', 'turning', 'transpalet']);
            $table->decimal('hourly_rate', 5, 2)->nullable();
            $table->string('photo')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('machines');
    }
}
