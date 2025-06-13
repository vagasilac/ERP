<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_issues', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coto_parties_id')->unsigned();
            $table->foreign('coto_parties_id')->references('id')->on('coto_parties')->onDelete('cascade');
            $table->string('issues_concern');
            $table->enum('bias', ['opportunity', 'risk', 'neutral', 'mixed']);
            $table->integer('processes_id')->unsigned()->nullable();
            $table->foreign('processes_id')->references('id')->on('processes')->onDelete('cascade');
            $table->enum('priority', ['emergency', 'high', 'medium', 'low']);
            $table->enum('treatment_method', ['accept_risk', 'risk_register', 'opportunity_register', 'root_cause_analysis', 'internal_auditing', 'corrective_action_request', 'vendor_auditing', 'other_auditing', 'management_review_activity', 'marketing_enhancement', 'other']);
            $table->text('other_treatment_method')->nullable();
            $table->text('record_reference')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coto_issues');
    }
}
