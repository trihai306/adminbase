<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeTable extends Migration
{
    public function up()
    {
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('attribute_id');
            $table->primary([
                'product_id',
                'attribute_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_attribute');
    }
}
