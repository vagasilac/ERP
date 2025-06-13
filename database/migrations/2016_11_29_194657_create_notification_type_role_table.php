<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTypeRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_type_role', function (Blueprint $table) {
            $table->integer('notification_type_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('notification_type_id')
                ->references('id')
                ->on('notification_types')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->primary(['notification_type_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_type_role');
    }
}
