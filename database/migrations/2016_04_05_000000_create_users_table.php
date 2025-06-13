<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('personal_email');
            $table->string('password', 60);
            $table->rememberToken();
            $table->timestamps();
            $table->string('job_title')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('country', 2)->nullable();
            $table->foreign('country')->references('code')->on('countries')->onDelete('set null');
            $table->string('phone')->nullable();
            $table->string('personal_phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('id_card')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('locker_room_number')->nullable();
            $table->string('rfid')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
