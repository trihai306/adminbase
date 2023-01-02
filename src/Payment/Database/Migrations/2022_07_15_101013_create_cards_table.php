<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\CardStatus;
use Modules\Payment\Enums\CardType;

class CreateCardsTable extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->enum('type', CardType::getValues());
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('values');
            $table->unsignedTinyInteger('discount_rate');
            $table->unsignedTinyInteger('index');
            $table->enum('status', CardStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
