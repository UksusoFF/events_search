<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_id');
            $table->string('uuid');
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->longText('description')->nullable();
            $table->longText('image')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
