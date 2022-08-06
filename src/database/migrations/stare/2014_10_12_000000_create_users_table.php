<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name', 400);
            $table->string('username', 150);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->integer('block')->default(0);
            $table->integer('sendEmail')->default('0');
            $table->datetime('lastvisitDate');
            $table->string('activation', 100);
            $table->mediumText('params');
            $table->string('otep', 100);
            $table->integer('requireReset')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
