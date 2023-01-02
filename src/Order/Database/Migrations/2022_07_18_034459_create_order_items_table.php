<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Order\Enums\OrderItemStatus;
use Modules\Catalog\Enums\OrderType;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('variant_id');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('discount_price')->nullable();
            $table->unsignedBigInteger('sale_price');
            $table->unsignedInteger('quantity');
            $table->enum('order_type', OrderType::getValues());
            $table->text('feedback')->nullable();
            $table->enum('status', OrderItemStatus::getValues())
                ->default(OrderItemStatus::NEW);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
