<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCheckMarksTable extends Migration
{
    public function up()
    {
        Schema::create('event_check_marks', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('user_id');

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
