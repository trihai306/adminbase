<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\PaymentType;
use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Enums\PaymentStatus;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payer_id')->index();
            $table->enum('type', PaymentType::getValues());
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('method_id');
            $table->enum('method_type', PaymentMethodType::getValues());
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('discount_rate');
            $table->unsignedBigInteger('receive_amount')->default(0);
            $table->timestamp('expire_at')->nullable();
            $table->string('feed_back')->nullable();
            $table->enum('status', PaymentStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
