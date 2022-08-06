<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('menutype', 24);
            $table->string('title', 255);
            $table->string('alias', 400);
            $table->string('path', 1024);
            $table->string('link', 1024);
            $table->string('type', 16);
            $table->tinyInteger('published');
            $table->integer('parent_id')->default('1');
            $table->integer('level')->default('0');
            $table->integer('access')->default('0');
            $table->string('img', 255);
            $table->mediumText('parms');
            $table->tinyInteger('client_id');
            $table->dateTime('publish_up')->nullable();
            $table->dateTime('publish_down')->nullable();
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
        Schema::dropIfExists('menu');
    }
}
