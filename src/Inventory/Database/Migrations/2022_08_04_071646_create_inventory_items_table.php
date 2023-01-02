<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Inventory\Enums\InventoryItemType;
use Modules\Inventory\Enums\InventoryItemStatus;

class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id')->index();
            $table->text('item');
            $table->unsignedBigInteger('importer_id')->index();
            $table->enum('status', InventoryItemStatus::getValues())
                ->default(InventoryItemStatus::AVAILABLE);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
