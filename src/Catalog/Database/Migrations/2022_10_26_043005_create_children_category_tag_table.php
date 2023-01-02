<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenCategoryTagTable extends Migration
{
    public function up()
    {
        Schema::create('children_category_tag', function (Blueprint $table) {
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
        Schema::dropIfExists('children_category_tag');
    }
}
