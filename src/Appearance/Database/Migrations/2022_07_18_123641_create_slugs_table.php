<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlugsTable extends Migration
{
    public function up()
    {
        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->morphs('slugable');
            $table->string('prefix')->nullable();
            $table->string('slug');
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique([
                'prefix',
                'slug'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('slugs');
    }
}
