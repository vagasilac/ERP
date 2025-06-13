<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotoOpportunityRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coto_opportunity_registers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('process_id')->unsigned();
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->integer('coto_issue_id')->unsigned();
            $table->foreign('coto_issue_id')->references('id')->on('coto_issues')->onDelete('cascade');
            $table->enum('likelihood', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('occurrences', ['1', '2', '3', '4', '5'])->default('1');
            $table->string('prob_rating')->default('1');
            $table->enum('potential_for_new_business', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('potential_expansion_of_current_business', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('potential_improvement_in_satisfying_regulations', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('potential_improvement_to_internal_qms_processes', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('improvement_to_company_reputation', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('potential_cost_of_implementation', ['1', '2', '3', '4', '5'])->default('1');
            $table->string('ben_rating')->default('1');
            $table->string('opp_factor')->default('1');
            $table->text('opportunity_pursuit_plan')->default('');
            $table->enum('post_implementation_success', ['1', '2', '3', '4', '5'])->default('1');
            $table->enum('status', ['open', 'closed'])->default('open');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coto_opportunity_registers');
    }
}
