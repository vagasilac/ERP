<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->integer('project_material_id')->unsigned()->nullable();
            $table->foreign('project_material_id')->references('id')->on('project_materials')->onDelete('set null');
            $table->integer('order_number')->unsigned()->nullable()->default(null);
            $table->foreign('order_number')->references('id')->on('inputs_outputs_register')->onDelete('set null');
            $table->integer('offer_number')->unsigned()->nullable()->default(null);
            $table->foreign('offer_number')->references('id')->on('inputs_outputs_register')->onDelete('set null');
            $table->date('date_ordered')->nullable()->default(null);
            $table->date('date_received')->nullable()->default(null);
            $table->date('date_stocked')->nullable()->default(null);
            $table->integer('supplier_id')->unsigned()->nullable()->default(null);
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->string('ctc_number')->nullable()->default(null);
            $table->string('ctc_sarja')->nullable()->default(null);
            $table->string('ctc_certificate_no')->nullable()->default(null);
            $table->integer('ctc_file')->unsigned()->nullable();
            $table->foreign('ctc_file')->references('id')->on('files')->onDelete('cascade');
            $table->enum('status', ['offer_sent', 'offer_received', 'order_sent', 'production', 'stock']);
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
        Schema::drop('project_offers');
    }
}
