<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantAttributeTable extends Migration
{
    public function up()
    {
        Schema::create('variant_attribute', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('value')->nullable();
            $table->primary([
                'variant_id',
                'attribute_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_attribute');
    }
}
