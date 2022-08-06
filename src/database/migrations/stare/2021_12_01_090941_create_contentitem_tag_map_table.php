<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentitemTagMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentitem_tag_map', function (Blueprint $table) {
            $table->id();
            $table->string('type_alias', 255);
            $table->integer('core_content_id');
            $table->integer('content_item_id');
            $table->mediumInteger('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contentitem_tag_map');
    }
}
