<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierRatingToOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_rating_to_option', function (Blueprint $table) {
            $table->integer('rating_id')->unsigned();
            $table->foreign('rating_id')->references('id')->on('supplier_ratings')->onDelete('cascade');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('supplier_rating_options')->onDelete('cascade');
            $table->decimal('value', 5, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('supplier_rating_to_option');
    }
}
