<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('code')->unique();
            $table->unsignedBigInteger('max_money');
            $table->unsignedBigInteger('discount');
            $table->unsignedInteger('quality');
            $table->unsignedBigInteger('point');
            $table->unsignedInteger('expire_day');
            $table->text('description')->nullable();
            $table->enum('status',\Modules\Catalog\Enums\VoucherStatus::getValues());
            $table->enum('type',\Modules\Catalog\Enums\VoucherType::getValues());
            $table->enum('options',\Modules\Catalog\Enums\VoucherOptions::getValues());
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
