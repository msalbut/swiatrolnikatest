<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default('0');
            $table->integer('level')->default('0');
            $table->string('path', 400);
            $table->string('title', 255);
            $table->string('alias', 400);
            $table->mediumText('description')->nullable();
            $table->tinyInteger('published')->default('0');
            $table->integer('access');
            $table->text('params')->nullable();
            $table->string('metadesc', 1024);
            $table->string('metakey', 1024);
            $table->string('metadata', 2048);
            $table->integer('created_user_id')->default('0');
            $table->integer('modified_user_id')->default('0');
            $table->integer('hits')->default('0');

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
        Schema::dropIfExists('category');
    }
}
