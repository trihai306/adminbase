<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadParticipantTable extends Migration
{
    public function up()
    {
        Schema::create('thread_participant', function (Blueprint $table) {
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('last_seen_at')->nullable();
            $table->primary([
                'thread_id',
                'user_id'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('thread_participant');
    }
}
