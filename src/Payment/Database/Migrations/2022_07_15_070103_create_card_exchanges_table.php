<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\CardType;
use Modules\Payment\Enums\CardExchangeStatus;

class CreateCardExchangesTable extends Migration
{
    public function up()
    {
        Schema::create('card_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('card_id');
            $table->enum('type', CardType::getValues());
            $table->string('serial');
            $table->string('code');
            $table->unsignedBigInteger('value');
            $table->unsignedBigInteger('real_value')->nullable();
            $table->unsignedFloat('discount_rate');
            $table->unsignedBigInteger('receive_amount');
            $table->text('feedback')->nullable();
            $table->enum('status', CardExchangeStatus::getValues())
                ->default(CardExchangeStatus::PENDING);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_exchanges');
    }
}
