<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suppliers_id')->unsigned();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->enum('type', ['contract', 'other']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('supplier_documents');
    }
}
