<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionTable extends Migration
{
    public function up()
    {
        Schema::create('product_option', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('option_id');
            $table->primary([
                'product_id',
                'option_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_option');
    }
}
