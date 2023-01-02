<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionProductTable extends Migration
{
    public function up()
    {
        Schema::create('promotion_product', function (Blueprint $table) {
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('product_id');
            $table->index([
                'promotion_id',
                'product_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotion_product');
    }
}
