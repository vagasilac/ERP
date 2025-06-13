<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalAuditProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_processes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_audit_id')->unsigned();
            $table->foreign('internal_audit_id')->references('id')->on('internal_audits')->onDelete('cascade');
            $table->integer('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('set null');
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
        Schema::drop('internal_audit_processes');
    }
}
