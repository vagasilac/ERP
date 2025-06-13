<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoRiskRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_risk_registers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coto_issue_id')->unsigned();
            $table->foreign('coto_issue_id')->references('id')->on('coto_issues')->onDelete('cascade');
            $table->integer('process_id')->unsigned();
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->enum('risk_likelihood', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_occurrences', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_potential_loss_of_contracts', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_potential_risk_to_human_health', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_inability_to_meet_contract_terms', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_potential_violation_of_regulations', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_impact_on_company_reputation', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('risk_est_cost_of_correction', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_likelihood', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_occurrences', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_potential_loss_of_contracts', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_potential_risk_to_human_health', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_inability_to_meet_contract_terms', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_potential_violation_of_regulations', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_impact_on_company_reputation', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('mitigation_est_cost_of_correction', ['1', '2', '3', '4', '5'])->default('1');
            $table->text('mitigation_plan')->default('');
            $table->string('risk_prob_rating')->default('1');
            $table->string('risk_cons_rating')->default('1');
            $table->string('before_risk_factor')->default('1');
            $table->string('mitigation_prob_rating')->default('1');
            $table->string('mitigation_cons_rating')->default('1');
            $table->string('after_risk_factor')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coto_risk_registers');
    }
}
