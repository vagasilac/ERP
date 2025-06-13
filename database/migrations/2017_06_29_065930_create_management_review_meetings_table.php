<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementReviewMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_review_meetings', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('accepted_policy', ['revised_and_accepted_policy', 'the_policy_needs_to_be_changed']);
            $table->text('policy_recommendation');
            $table->enum('accepted_issues', ['list_of_revised_and_accepted_issues', 'the_list_must_be_changed']);
            $table->text('issues_recommendation');
            $table->text('audit_note');
            $table->text('infrastructure');
            $table->text('qms');
            $table->text('hr');
            $table->text('education_note');
            $table->text('customer_feedback_note');
            $table->text('integrated_management_system_note');
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
        Schema::drop('management_review_meetings');
    }
}
