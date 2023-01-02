<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantOptionValueTable extends Migration
{
    public function up()
    {
        Schema::create('variant_option_value', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('option_value_id');
            $table->primary([
                'variant_id',
                'option_value_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_option_value');
    }
}
