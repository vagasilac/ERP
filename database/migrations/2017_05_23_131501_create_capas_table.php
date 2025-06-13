<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capas', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['corrective_action', 'opportunity_for_improvement', 'preventive_action', 'corrective_action_provider']);
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->enum('source', ['employee_feedback', 'customer_feedback', 'supplier_feedback', 'external_audit_finding', 'internal_audit_finding', 'management_review_action_item', 'other']);
            $table->string('other_source');
            $table->integer('process_id')->unsigned()->nullable();
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->string('other_process');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->text('description');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('capas');
    }
}
