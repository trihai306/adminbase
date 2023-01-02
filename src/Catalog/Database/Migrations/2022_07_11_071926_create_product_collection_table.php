<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCollectionTable extends Migration
{
    public function up()
    {
        Schema::create('product_collection', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('collection_id');
            $table->primary([
                'product_id',
                'collection_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_collection');
    }
}
