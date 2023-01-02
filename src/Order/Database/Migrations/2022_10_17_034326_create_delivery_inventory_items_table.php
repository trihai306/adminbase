<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->unsignedBigInteger('inventory_item_id')->nullable();
            $table->text('item');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_inventory_items');
    }
}
