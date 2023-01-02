<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\User\Enums\UserStatus;
use Modules\User\Enums\UserGender;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', UserGender::getValues())->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('points')->default(0);
            $table->boolean('is_admin')->default(false);
            $table->enum('status', UserStatus::getValues())->default(UserStatus::ACTIVATED);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
