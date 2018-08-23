<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('source');
            $table->string('map_items')->nullable();
            $table->string('map_id')->nullable();
            $table->string('map_title')->nullable();
            $table->string('map_description')->nullable();
            $table->string('map_image')->nullable();
            $table->string('map_date')->nullable();
            $table->string('map_date_format')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
