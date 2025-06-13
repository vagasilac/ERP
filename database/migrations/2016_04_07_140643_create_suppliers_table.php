<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name', 100)->nullable();
            $table->timestamps();
            $table->integer('type')->unsigned()->nullable();
            $table->foreign('type')->references('id')->on('supplier_types')->onDelete('set null');
            $table->string('company_number', 30)->nullable();
            $table->string('vat_number', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('country', 2)->nullable();
            $table->foreign('country')->references('code')->on('countries')->onDelete('set null');
            $table->string('website')->nullable();
            $table->string('office_email')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('suppliers');
    }
}
