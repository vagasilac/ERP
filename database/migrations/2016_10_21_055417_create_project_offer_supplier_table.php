<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectOfferSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_offer_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_offer_id')->unsigned()->nullable();
            $table->foreign('project_offer_id')->references('id')->on('project_offers')->onDelete('set null');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->enum('status', ['offer_sent', 'offer_received', 'request_sent', 'request_accepted'])->default('offer_sent');
            $table->decimal('price', 10, 2)->nullable()->default(null);
            $table->string('offer_number')->nullable()->default(null);
            $table->date('offer_received_at')->nullable()->default(null);
            $table->string('offer_received_number')->nullable()->default(null);
            $table->integer('offer_file')->unsigned()->nullable();
            $table->foreign('offer_file')->references('id')->on('files')->onDelete('set null');
            $table->string('request_number')->nullable()->default(null);
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
        Schema::drop('project_offer_supplier');
    }
}
