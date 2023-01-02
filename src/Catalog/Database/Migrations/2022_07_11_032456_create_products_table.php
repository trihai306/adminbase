<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Enums\VariantMatchingMethod;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->unsignedBigInteger('brand_id')->index()->nullable();
            $table->enum('variant_matching_method', VariantMatchingMethod::getValues())->nullable();
            $table->unsignedBigInteger('initial_sold_count')->default(0);
            $table->text('important_message')->nullable();
            $table->enum('status', ProductStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
