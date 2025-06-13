<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalAuditReportReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_report_reviews', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_audit_report_id')->unsigned();
            $table->foreign('internal_audit_report_id')->references('id')->on('internal_audit_reports')->onDelete('cascade');
            $table->text('review_report_question');
            $table->enum('review_report_yes_no', ['yes', 'no']);
            $table->text('review_report_proof_or_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('internal_audit_report_reviews');
    }
}
