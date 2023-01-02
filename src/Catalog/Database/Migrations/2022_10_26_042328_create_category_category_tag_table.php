<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryCategoryTagTable extends Migration
{
    public function up()
    {
        Schema::create('category_category_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('category_tag_id');

            $table->primary([
                'category_id',
                'category_tag_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_category_tag');
    }
}
