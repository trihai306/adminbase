<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideItemsTable extends Migration
{
    public function up()
    {
        Schema::create('slide_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slide_id');
            $table->string('image');
            $table->string('url')->nullable();
            $table->unsignedTinyInteger('index');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slide_items');
    }
}
