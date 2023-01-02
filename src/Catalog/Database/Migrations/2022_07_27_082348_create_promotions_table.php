<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Catalog\Enums\PromotionScopeType;
use Modules\Catalog\Enums\PromotionActionType;
use Modules\Catalog\Enums\PromotionStatus;

class CreatePromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('scope_type', PromotionScopeType::getValues());
            $table->enum('action_type', PromotionActionType::getValues());
            $table->unsignedBigInteger('action_amount');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->enum('status', PromotionStatus::getValues());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
