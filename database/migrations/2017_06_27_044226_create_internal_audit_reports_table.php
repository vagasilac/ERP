<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalAuditReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_reports', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_audit_id')->unsigned();
            $table->foreign('internal_audit_id')->references('id')->on('internal_audits')->onDelete('cascade');
            $table->integer('auditor_id')->unsigned()->nullable();
            $table->foreign('auditor_id')->references('id')->on('users')->onDelete('set null');
            $table->text('documentation_suggestions')->nullable();
            $table->text('review_report_problems_discovered')->nullable();
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
        Schema::drop('internal_audit_reports');
    }
}
