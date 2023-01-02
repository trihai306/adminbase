<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\EwalletStatus;

class CreateEwalletsTable extends Migration
{
    public function up()
    {
        Schema::create('ewallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('account_name');
            $table->string('account_number');
            $table->unsignedTinyInteger('discount_rate');
            $table->unsignedTinyInteger('index');
            $table->enum('status', EwalletStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ewallets');
    }
}
