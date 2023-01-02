<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Catalog\Enums\HistoryPointType;

class CreateHistoryPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('voucher_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_id');
            $table->unsignedBigInteger('point');
            $table->text('note');
            $table->enum('type',HistoryPointType::getvalues());
            $table->enum('status',\Modules\Catalog\Enums\HistoryPointStatus::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_points');
    }
}
