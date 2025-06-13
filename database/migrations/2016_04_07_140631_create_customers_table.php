<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name', 100)->nullable();
            $table->timestamps();
            $table->string('company_number', 30)->nullable();
            $table->string('vat_number', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('country', 2)->nullable();
            $table->foreign('country')->references('code')->on('countries')->onDelete('set null');
            $table->text('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_county')->nullable();
            $table->string('delivery_country', 2)->nullable();
            $table->foreign('delivery_country')->references('code')->on('countries')->onDelete('set null');
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
        Schema::drop('customers');
    }
}
