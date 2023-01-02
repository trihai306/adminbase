<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\BankStatus;

class CreateBanksTable extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('branch');
            $table->unsignedTinyInteger('discount_rate');
            $table->unsignedTinyInteger('index');
            $table->enum('status', BankStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
