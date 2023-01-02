<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\PaymentMethodStatus;
use Modules\Payment\Enums\PaymentMethodType;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', PaymentMethodType::getValues());
            $table->string('code')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('config')->nullable();
            $table->boolean('checkout_enabled')->default(true);
            $table->boolean('recharge_enabled')->default(true);
            $table->enum('status', PaymentMethodStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
