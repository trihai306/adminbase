<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedProductTable extends Migration
{
    public function up()
    {
        Schema::create('related_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('related_product_id');
            $table->primary([
                'product_id',
                'related_product_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('related_product');
    }
}
