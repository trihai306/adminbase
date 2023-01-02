<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_voucher', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('variant_id');
            $table->unsignedInteger('voucher_id');
            $table->enum('status',\Modules\Catalog\Enums\VariantVoucher::getValues());
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
        Schema::dropIfExists('variant_voucher');
    }
}
