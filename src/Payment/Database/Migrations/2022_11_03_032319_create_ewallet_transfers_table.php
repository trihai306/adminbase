<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payment\Enums\EwalletTransferStatus;

class CreateEwalletTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('ewallet_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('ewallet_id');
            $table->string('ref')->nullable();
            $table->string('content');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('discount_rate');
            $table->unsignedBigInteger('receive_amount');
            $table->timestamp('transacted_at')->nullable();
            $table->string('bill')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status', EwalletTransferStatus::getValues())
                ->default(EwalletTransferStatus::PENDING);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ewallet_transfers');
    }
}
